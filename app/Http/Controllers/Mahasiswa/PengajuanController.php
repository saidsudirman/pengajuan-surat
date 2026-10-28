<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\DokumenPengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view(
            'mahasiswa.pengajuan.create',
            compact('jenisSurats', 'mahasiswa')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'dokumen.*.max' => 'Ukuran dokumen maksimal 2 MB.',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        $jenisSurat = JenisSurat::where('status', 'aktif')
            ->findOrFail($request->jenis_surat_id);

        $uploadedPaths = [];
        $pdfPath = null;

        try {
            $pengajuan = DB::transaction(function () use ($request, $mahasiswa, $jenisSurat, &$uploadedPaths, &$pdfPath) {
                $nomorPengajuan = 'SRT-' . now()->format('Ymd') .
                    '-' . strtoupper(Str::random(4));

                $pengajuan = PengajuanSurat::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'jenis_surat_id' => $jenisSurat->id,
                    'nomor_pengajuan' => $nomorPengajuan,
                    'keperluan' => $request->keperluan,
                    'status' => 'menunggu',
                    'tanggal_diproses' => null,
                    'tanggal_selesai' => null,
                ]);

                if ($request->hasFile('dokumen')) {
                    foreach ($request->file('dokumen') as $file) {
                        $filename = now()->format('YmdHis') .
                            '_' . Str::random(8) .
                            '.' . $file->getClientOriginalExtension();

                        $path = $file->storeAs(
                            'pengajuan_dokumen',
                            $filename,
                            'public'
                        );

                        if (!$path) {
                            throw new \RuntimeException(
                                'Dokumen persyaratan gagal disimpan.'
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

                /*
                 * Pembuatan otomatis saat ini hanya disiapkan
                 * untuk Surat Keterangan Aktif Kuliah.
                 *
                 * Jenis surat lain memerlukan template masing-masing.
                 */
                if (
                    Str::contains(
                        Str::lower($jenisSurat->nama_surat),
                        'aktif kuliah'
                    )
                ) {
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

                    $nomorUrut = PengajuanSurat::whereNotNull('nomor_surat')->count() + 1;

                    $nomorSurat = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT)
                        . '/UNDIPA/H.1/'
                        . $bulanRomawi[now()->month]
                        . '/'
                        . now()->year;

                    $pdf = Pdf::loadView(
                        'pdf.surat-aktif-kuliah',
                        [
                            'nomorSurat' => $nomorSurat,
                            'mahasiswa' => $mahasiswa,
                            'namaPejabat' => 'Belum ditetapkan',
                            'nipPejabat' => '-',
                            'jabatanPejabat' => 'Pejabat berwenang',
                            'semester' => $mahasiswa->semester ?? '-',
                            'periode' => $mahasiswa->tahun_akademik ?? '-',
                            'tanggalSurat' => now()->translatedFormat('d F Y'),
                        ]
                    )->setPaper('a4', 'portrait');

                    $pdfPath = 'surat/' . $pengajuan->id .
                        '_' . Str::random(8) . '.pdf';

                    $saved = Storage::disk('public')->put(
                        $pdfPath,
                        $pdf->output()
                    );

                    if (!$saved) {
                        throw new \RuntimeException(
                            'PDF surat gagal disimpan.'
                        );
                    }

                    /*
                     * Simpan nomor surat dan lokasi PDF.
                     * Nomor AUTO merupakan nomor contoh, bukan
                     * nomor surat resmi yang ditetapkan kampus.
                     */
                    $pengajuan->update([
                        'nomor_surat' => $nomorSurat,
                        'file_surat' => $pdfPath,
                        'status' => 'menunggu',
                        'tanggal_diproses' => null,
                        'tanggal_selesai' => null,
                    ]);
                }

                return $pengajuan;
            });

            $pesan = $pengajuan->file_surat
                ? 'PDF contoh berhasil dibuat. Dokumen belum menjadi surat resmi sampai format, nomor surat, dan pengesahannya disetujui kampus.'
                : 'Pengajuan tersimpan. Template otomatis untuk jenis surat ini belum tersedia.';

            return redirect()
                ->route('mahasiswa.pengajuan.show', $pengajuan)
                ->with('success', $pesan);

        } catch (Throwable $e) {
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            if ($pdfPath) {
                Storage::disk('public')->delete($pdfPath);
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengajuan gagal diproses. Periksa konfigurasi PDF dan log Laravel.'
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
            'jenisSurat',
            'dokumenPengajuans',
        ]);

        return view(
            'mahasiswa.pengajuan.show',
            compact('pengajuan')
        );
    }

    public function cancel(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403);

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

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => 'Dibatalkan oleh mahasiswa.',
        ]);

        return redirect()
            ->route('mahasiswa.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }


    public function download(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403, 'Data mahasiswa tidak ditemukan.');

        abort_if(
            $pengajuan->mahasiswa_id !== $mahasiswa->id,
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

        $namaFile = 'Surat_' . $nomorFile . '.pdf';

        return response()->download(
            Storage::disk('public')->path($pengajuan->file_surat),
            $namaFile,
            ['Content-Type' => 'application/pdf']
        );

    }

}
