<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailPengajuan;
use App\Models\DokumenPengajuan;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\RiwayatPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanSurat::with(['mahasiswa', 'jenisSurat']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($qm) use ($search) {
                        $qm->where('nama', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();
        $jenisSurats = JenisSurat::orderBy('nama_surat')->get();

        return view('admin.pengajuan-surats.index', compact('pengajuans', 'jenisSurats'));
    }

    public function show(PengajuanSurat $pengajuanSurat)
    {
        $pengajuanSurat->load([
            'mahasiswa.user',
            'jenisSurat',
            'detailPengajuan',
            'dokumenPengajuans',
            'riwayatPengajuans.user',
        ]);

        return view('admin.pengajuan-surats.show', compact('pengajuanSurat'));
    }

    public function update(Request $request, PengajuanSurat $pengajuanSurat)
    {
        if ($request->filled('status_dokumen')) {
            $validated = $request->validate([
                'dokumen_id' => 'required|integer',
                'status_dokumen' => 'required|in:valid,tidak_valid',
                'keterangan_dokumen' => 'nullable|string|max:1000',
            ]);

            $dokumen = DokumenPengajuan::where('pengajuan_surat_id', $pengajuanSurat->id)
                ->findOrFail($validated['dokumen_id']);

            $dokumen->update([
                'status' => $validated['status_dokumen'],
                'keterangan' => $validated['status_dokumen'] === 'tidak_valid'
                    ? ($validated['keterangan_dokumen'] ?? 'Dokumen tidak valid.')
                    : null,
            ]);

            return back()->with(
                'success',
                $validated['status_dokumen'] === 'valid'
                    ? 'Dokumen berhasil dinyatakan valid.'
                    : 'Dokumen dinyatakan tidak valid.'
            );
        }

        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        if (!in_array($pengajuanSurat->status, ['menunggu', 'diproses'], true)) {
            return back()->with(
                'error',
                'Pengajuan tidak dapat diproses. Status saat ini: ' . $pengajuanSurat->status
            );
        }
if ($validated['status'] === 'diterima') {
    $dokumenBelumValid = $pengajuanSurat->dokumenPengajuans()
        ->where(function ($query) {
            $query->where('status', '!=', 'valid')
                ->orWhereNull('status');
        })
        ->exists();

    if ($dokumenBelumValid) {
        return back()->with(
            'error',
            'Persetujuan gagal. Pastikan seluruh dokumen pendukung sudah dinyatakan valid.'
        );
    }
}

        if ($validated['status'] === 'ditolak' && empty(trim($validated['catatan_admin'] ?? ''))) {
            return back()->withErrors([
                'catatan_admin' => 'Alasan penolakan wajib diisi.',
            ])->withInput();
        }

        DB::transaction(function () use ($pengajuanSurat, $validated) {
            $pengajuanSurat->update([
                'status' => $validated['status'],
                'catatan_admin' => $validated['status'] === 'ditolak'
                    ? $validated['catatan_admin']
                    : null,
                'tanggal_diproses' => now(),
                'tanggal_selesai' => null,
            ]);

            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuanSurat->id,
                'user_id' => Auth::id(),
                'status' => $validated['status'],
                'catatan' => $validated['status'] === 'ditolak'
                    ? $validated['catatan_admin']
                    : 'Pengajuan telah disetujui oleh admin dan menunggu pembuatan PDF surat.',
            ]);
        });

        return redirect()
            ->route('admin.pengajuan-surats.show', $pengajuanSurat)
            ->with(
                'success',
                $validated['status'] === 'diterima'
                    ? 'Pengajuan berhasil disetujui. Selanjutnya surat PDF perlu dibuat.'
                    : 'Pengajuan berhasil ditolak.'
            );
    }
    
public function generatePdf(PengajuanSurat $pengajuanSurat)
{
    if ($pengajuanSurat->status !== 'diterima') {
        return back()->with('error', 'Hanya pengajuan yang sudah disetujui yang dapat dibuatkan PDF.');
    }

    $pengajuanSurat->load([
        'mahasiswa',
        'jenisSurat',
        'detailPengajuan',
    ]);

    $pengaturan = PengaturanSurat::first();

    if (!$pengaturan) {
        return back()->with('error', 'Pengaturan surat universitas belum tersedia.');
    }

    if (empty($pengajuanSurat->jenisSurat->isi_template)) {
        return back()->with('error', 'Template isi surat belum diisi.');
    }

    $mahasiswa = $pengajuanSurat->mahasiswa;
    $dataTambahan = $pengajuanSurat->detailPengajuan?->data_tambahan ?? [];

    $data = [
        'nama' => $mahasiswa->nama,
        'nim' => $mahasiswa->nim,
        'tempat_lahir' => $mahasiswa->tempat_lahir,
        'tanggal_lahir' => $mahasiswa->tanggal_lahir?->format('d-m-Y'),
        'jenis_kelamin' => $mahasiswa->jenis_kelamin,
        'alamat' => $mahasiswa->alamat,
        'no_hp' => $mahasiswa->no_hp,
        'fakultas' => $mahasiswa->fakultas,
        'program_studi' => $mahasiswa->program_studi,
        'angkatan' => $mahasiswa->angkatan,
        'semester' => $mahasiswa->semester,
        'tahun_akademik' => $mahasiswa->tahun_akademik,
        'nomor_pengajuan' => $pengajuanSurat->nomor_pengajuan,
        'keperluan' => $pengajuanSurat->keperluan,
        'tanggal_surat' => now()->translatedFormat('d F Y'),
    ];

    $data = array_merge($data, $dataTambahan);

    $isiTemplate = preg_replace_callback(
        '/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/',
        function ($matches) use ($data) {
            $nilai = $data[$matches[1]] ?? '-';

            if (is_array($nilai)) {
                $nilai = implode(', ', $nilai);
            }

            return e((string) $nilai);
        },
        $pengajuanSurat->jenisSurat->isi_template
    );

    $gambar = [];

    foreach (['logo', 'tanda_tangan', 'stempel'] as $field) {
        $path = $pengaturan->$field
            ? Storage::disk('public')->path($pengaturan->$field)
            : null;

        $gambar[$field] = $path && file_exists($path)
            ? 'data:' . mime_content_type($path) . ';base64,' . base64_encode(file_get_contents($path))
            : null;
    }

    $pdf = Pdf::loadView('admin.pengajuan-surats.pdf', [
        'pengajuanSurat' => $pengajuanSurat,
        'pengaturan' => $pengaturan,
        'isiTemplate' => $isiTemplate,
        'gambar' => $gambar,
        'tanggalCetak' => now()->translatedFormat('d F Y'),
    ])->setPaper('a4', 'portrait');

    $namaFile = 'surat-' . $pengajuanSurat->nomor_pengajuan . '.pdf';
    $pathFile = 'surat-terbit/' . $namaFile;

    $berhasilSimpan = Storage::disk('public')->put($pathFile, $pdf->output());

if (!$berhasilSimpan) {
    return back()->with('error', 'PDF gagal disimpan. Periksa konfigurasi storage.');
}

    try {
        DB::transaction(function () use ($pengajuanSurat, $pathFile) {
            $pengajuanSurat->update([
                'file_surat' => $pathFile,
                'status' => 'selesai',
                'tanggal_selesai' => now(),
            ]);

            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuanSurat->id,
                'user_id' => Auth::id(),
                'status' => 'selesai',
                'catatan' => 'PDF surat berhasil dibuat dan diterbitkan.',
            ]);
        });
    } catch (\Throwable $e) {
        Storage::disk('public')->delete($pathFile);
        throw $e;
    }

    return redirect()
        ->route('admin.pengajuan-surats.show', $pengajuanSurat)
        ->with('success', 'PDF surat berhasil dibuat dan diterbitkan.');
}

}
