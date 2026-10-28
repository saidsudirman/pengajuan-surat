<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DetailPengajuan;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\RiwayatPengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403);

        $pengajuans = PengajuanSurat::with('jenisSurat')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.pengajuan-surats.index', compact('pengajuans'));
    }

    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403);

        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view(
            'mahasiswa.pengajuan-surats.create',
            compact('jenisSurats', 'mahasiswa')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat_id' => [
                'required',
                'exists:jenis_surats,id',
            ],
            'keperluan' => [
                'required',
                'string',
                'max:5000',
            ],
            'file_persyaratan' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(!$mahasiswa, 403);

        $jenisSurat = JenisSurat::where('status', 'aktif')
            ->findOrFail($validated['jenis_surat_id']);

        $filePersyaratan = null;

        if ($request->hasFile('file_persyaratan')) {
            $filePersyaratan = $request->file('file_persyaratan')
                ->store('persyaratan', 'local');
        }

        try {
            $pengajuan = DB::transaction(function () use ($validated, $mahasiswa, $jenisSurat, $filePersyaratan) {
                $now = now();

                $pengajuan = PengajuanSurat::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'jenis_surat_id' => $jenisSurat->id,
                    'nomor_pengajuan' => 'PGJ-' .
                        $now->format('Ymd') . '-' .
                        strtoupper(Str::random(8)),
                    'keperluan' => $validated['keperluan'],
                    'status' => 'selesai',
                    'file_persyaratan' => $filePersyaratan,
                    'tanggal_diproses' => $now,
                    'tanggal_selesai' => $now,
                ]);

                // Format nomor ini adalah contoh dan perlu disesuaikan
                // dengan ketentuan penomoran resmi kampus.
                $nomorSurat = 'UNDIPA/SRT/' .
                    $now->format('Y') . '/' .
                    str_pad((string) $pengajuan->id, 6, '0', STR_PAD_LEFT);

                $pengajuan->update([
                    'nomor_surat' => $nomorSurat,
                ]);

                DetailPengajuan::create([
                    'pengajuan_surat_id' => $pengajuan->id,
                    'nama_mahasiswa' => $mahasiswa->nama,
                    'nim' => $mahasiswa->nim,
                    'program_studi' => $mahasiswa->program_studi,
                    'fakultas' => $mahasiswa->fakultas,
                    'semester' => $mahasiswa->semester,
                    'tahun_akademik' => $mahasiswa->tahun_akademik,
                ]);

                RiwayatPengajuan::create([
                    'pengajuan_surat_id' => $pengajuan->id,
                    'status' => 'selesai',
                    'catatan' => 'Surat diterbitkan otomatis oleh sistem.',
                ]);

                $logoPath = public_path('images/logo-undipa.png');

                $tandaTanganPath = public_path(
                    'images/tanda-tangan-pejabat.png'
                );

                $capPath = public_path('images/cap-resmi.png');

                $pdf = Pdf::loadView('pdf.surat', [
                    'pengajuan' => $pengajuan->load([
                        'mahasiswa',
                        'jenisSurat',
                        'detailPengajuan',
                    ]),
                    'logoPath' => file_exists($logoPath)
                        ? $logoPath : null,
                    'tandaTanganPath' => file_exists($tandaTanganPath)
                        ? $tandaTanganPath : null,
                    'capPath' => file_exists($capPath)
                        ? $capPath : null,
                ])->setPaper('a4', 'portrait');

                $fileName = 'surat/' .
                    $pengajuan->id . '-' .
                    Str::slug($nomorSurat) . '.pdf';

                Storage::disk('local')->put(
                    $fileName,
                    $pdf->output()
                );

                $pengajuan->update([
                    'file_surat' => $fileName,
                ]);

                return $pengajuan;
            });
        } catch (\Throwable $exception) {
            report($exception);

            if ($filePersyaratan) {
                Storage::disk('local')->delete($filePersyaratan);
            }

            throw ValidationException::withMessages([
                'pengajuan' => 'Surat belum berhasil dibuat. Silakan periksa data dan coba kembali.',
            ]);
        }

        return redirect()
            ->route('mahasiswa.pengajuan-surats.show', $pengajuan)
            ->with('success', 'Surat berhasil dibuat dan siap diunduh.');
    }

    public function show(PengajuanSurat $pengajuanSurat)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(
            !$mahasiswa ||
            (int) $pengajuanSurat->mahasiswa_id !== (int) $mahasiswa->id,
            403
        );

        $pengajuanSurat->load([
            'jenisSurat',
            'detailPengajuan',
            'riwayatPengajuans',
        ]);

        return view(
            'mahasiswa.pengajuan-surats.show',
            compact('pengajuanSurat')
        );
    }

    public function download(PengajuanSurat $pengajuanSurat)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        abort_if(
            !$mahasiswa ||
            (int) $pengajuanSurat->mahasiswa_id !== (int) $mahasiswa->id,
            403
        );

        $fileSurat = $pengajuanSurat->file_surat;

        abort_unless(
            $fileSurat && Storage::disk('local')->exists($fileSurat),
            404,
            'File surat tidak ditemukan.'
        );

        $path = Storage::disk('local')->path($fileSurat);

        return response()->download(
            $path,
            'Surat-' . ($pengajuanSurat->nomor_surat ?? $pengajuanSurat->nomor_pengajuan) . '.pdf'
        );
    }
}
