<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailPengajuan;
use App\Models\DokumenPengajuan;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\RiwayatPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        $query = PengajuanSurat::with('jenisSurat')
            ->where('mahasiswa_id', $mahasiswa->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('search')) {
            $query->where(
                'nomor_pengajuan',
                'like',
                '%' . $request->search . '%'
            );
        }

        $pengajuans = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view(
            'mahasiswa.pengajuan.index',
            compact('pengajuans', 'jenisSurats')
        );
    }

    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        $jenisSurats = JenisSurat::with('fieldSurats')
            ->where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view(
            'mahasiswa.pengajuan.create',
            compact('jenisSurats', 'mahasiswa')
        );
    }

    public function store(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        $validated = $request->validate([
            'jenis_surat_id' => [
                'required',
                'integer',
                'exists:jenis_surats,id',
            ],
            'keperluan' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
            'data_tambahan' => [
                'nullable',
                'array',
            ],
            'dokumen' => [
                'nullable',
                'array',
            ],
            'dokumen.*' => [
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ], [
            'jenis_surat_id.required' => 'Pilih jenis surat terlebih dahulu.',
            'jenis_surat_id.exists' => 'Jenis surat tidak ditemukan.',
            'keperluan.required' => 'Keperluan pengajuan wajib diisi.',
            'keperluan.min' => 'Keperluan minimal 10 karakter.',
            'keperluan.max' => 'Keperluan maksimal 500 karakter.',
            'dokumen.*.mimes' => 'Dokumen harus berupa PDF, JPG, atau PNG.',
            'dokumen.*.max' => 'Ukuran setiap dokumen maksimal 2 MB.',
        ]);

        $jenisSurat = JenisSurat::with('fieldSurats')
            ->where('status', 'aktif')
            ->findOrFail($validated['jenis_surat_id']);

        $dynamicRules = [];

        foreach ($jenisSurat->fieldSurats as $field) {
            $aturan = $field->wajib_diisi
                ? ['required']
                : ['nullable'];

            switch ($field->tipe) {
                case 'number':
                    $aturan[] = 'numeric';
                    break;

                case 'date':
                    $aturan[] = 'date';
                    break;

                case 'email':
                    $aturan[] = 'email';
                    break;

                default:
                    $aturan[] = 'string';
                    $aturan[] = 'max:2000';
                    break;
            }

            $dynamicRules['data_tambahan.' . $field->nama_field] = $aturan;
        }

        $validatedDynamic = $request->validate($dynamicRules);

        $fieldDiizinkan = $jenisSurat->fieldSurats
            ->pluck('nama_field')
            ->all();

        $dataTambahan = collect(
            $validatedDynamic['data_tambahan'] ?? []
        )->only($fieldDiizinkan)->all();

        $uploadedPaths = [];

        try {
            $pengajuan = DB::transaction(function () use (
                $request,
                $mahasiswa,
                $jenisSurat,
                $validated,
                $dataTambahan,
                &$uploadedPaths
            ) {
                $tahun = now()->year;

                $bulanRomawi = [
                    1 => 'I',
                    2 => 'II',
                    3 => 'III',
                    4 => 'IV',
                    5 => 'V',
                    6 => 'VI',
                    7 => 'VII',
                    8 => 'VIII',
                    9 => 'IX',
                    10 => 'X',
                    11 => 'XI',
                    12 => 'XII',
                ];

                $nomorUrut = PengajuanSurat::whereYear('created_at', $tahun)
                    ->lockForUpdate()
                    ->count() + 1;

                do {
                    $nomorPengajuan = $nomorUrut . '/UNDIPA/H.1/' .
                        $bulanRomawi[now()->month] . '/' . $tahun;

                    $nomorSudahDigunakan = PengajuanSurat::where(
                        'nomor_pengajuan',
                        $nomorPengajuan
                    )->exists();

                    if ($nomorSudahDigunakan) {
                        $nomorUrut++;
                    }
                } while ($nomorSudahDigunakan);

                $pengajuan = PengajuanSurat::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'jenis_surat_id' => $jenisSurat->id,
                    'nomor_pengajuan' => $nomorPengajuan,
                    'keperluan' => $validated['keperluan'],
                    'status' => 'menunggu',
                    'tanggal_diproses' => null,
                    'tanggal_selesai' => null,
                ]);

                DetailPengajuan::create([
                    'pengajuan_surat_id' => $pengajuan->id,
                    'data_tambahan' => $dataTambahan,
                ]);

                if ($request->hasFile('dokumen')) {
                    foreach ($request->file('dokumen') as $file) {
                        $namaFile = now()->format('YmdHis') .
                            '_' . Str::random(12) .
                            '.' . $file->getClientOriginalExtension();

                        $path = $file->storeAs(
                            'pengajuan_dokumen',
                            $namaFile,
                            'public'
                        );

                        if (!$path) {
                            throw new \RuntimeException(
                                'Dokumen gagal disimpan.'
                            );
                        }

                        $uploadedPaths[] = $path;

                        DokumenPengajuan::create([
                            'pengajuan_surat_id' => $pengajuan->id,
                            'nama_dokumen' => $file->getClientOriginalName(),
                            'file' => $path,
                            'status' => 'menunggu',
                            'keterangan' => null,
                        ]);
                    }
                }

                RiwayatPengajuan::create([
                    'pengajuan_surat_id' => $pengajuan->id,
                    'user_id' => Auth::id(),
                    'status' => 'menunggu',
                    'catatan' => 'Mahasiswa mengajukan surat.',
                ]);

                return $pengajuan;
            });

            return redirect()
                ->route('mahasiswa.pengajuan.show', $pengajuan)
                ->with(
                    'success',
                    'Pengajuan surat berhasil dikirim dan menunggu verifikasi admin.'
                );

        } catch (Throwable $e) {
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengajuan gagal disimpan. Silakan periksa kembali data dan dokumen.'
                );
        }
    }

    public function show(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        abort_if(
            (int) $pengajuan->mahasiswa_id !== (int) $mahasiswa->id,
            403,
            'Anda tidak berhak mengakses pengajuan ini.'
        );

        $pengajuan->load([
            'mahasiswa',
            'jenisSurat.fieldSurats',
            'detailPengajuan',
            'dokumenPengajuans',
            'riwayatPengajuans.user',
        ]);

        return view(
            'mahasiswa.pengajuan.show',
            compact('pengajuan')
        );
    }

    public function cancel(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        abort_if(
            (int) $pengajuan->mahasiswa_id !== (int) $mahasiswa->id,
            403,
            'Anda tidak berhak membatalkan pengajuan ini.'
        );

        if (!in_array($pengajuan->status, ['menunggu', 'diproses'], true)) {
            return back()->with(
                'error',
                'Pengajuan ini tidak dapat dibatalkan.'
            );
        }

        DB::transaction(function () use ($pengajuan) {
            $pengajuan->update([
                'status' => 'ditolak',
                'catatan_admin' => 'Pengajuan dibatalkan oleh mahasiswa.',
            ]);

            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuan->id,
                'user_id' => Auth::id(),
                'status' => 'ditolak',
                'catatan' => 'Pengajuan dibatalkan oleh mahasiswa.',
            ]);
        });

        return redirect()
            ->route('mahasiswa.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function download(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        abort_if(
            (int) $pengajuan->mahasiswa_id !== (int) $mahasiswa->id,
            403,
            'Anda tidak memiliki akses ke surat ini.'
        );

        abort_if(
            $pengajuan->status !== 'selesai',
            404,
            'Surat belum selesai dibuat.'
        );

        abort_if(
            !$pengajuan->file_surat ||
            !Storage::disk('public')->exists($pengajuan->file_surat),
            404,
            'File surat tidak ditemukan.'
        );

        $nomorFile = $pengajuan->nomor_surat
            ?: $pengajuan->nomor_pengajuan;

        $nomorFile = str_replace(
            ['/', '\\'],
            '-',
            $nomorFile
        );

        return response()->download(
            Storage::disk('public')->path($pengajuan->file_surat),
            'Surat_' . $nomorFile . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}