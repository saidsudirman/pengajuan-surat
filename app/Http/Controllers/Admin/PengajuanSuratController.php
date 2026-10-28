<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
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

        // Ambil jenis surat untuk dropdown filter
        $jenisSurats = JenisSurat::orderBy('nama_surat')->get();

        return view('admin.pengajuan-surats.index', compact('pengajuans', 'jenisSurats'));
    }

    public function show(PengajuanSurat $pengajuanSurat)
    {
        $pengajuanSurat->load([
            'mahasiswa',
            'jenisSurat',
            'detailPengajuan',
            'dokumenPengajuans',
            'riwayatPengajuans',
        ]);

        return view(
            'admin.pengajuan-surats.show',
            compact('pengajuanSurat')
        );
    }




public function update(Request $request, PengajuanSurat $pengajuanSurat)
{
    $validated = $request->validate([
        'status' => 'required|in:selesai,ditolak',
        'catatan_admin' => 'nullable|string|max:1000',
    ]);

    if (!in_array($pengajuanSurat->status, ['menunggu', 'diproses'], true)) {
        return back()->with(
            'error',
            'Pengajuan tidak dapat diproses. Status saat ini: ' . $pengajuanSurat->status
        );
    }

    if ($validated['status'] === 'selesai') {
        $fileSurat = $pengajuanSurat->file_surat;

        if (empty($fileSurat)) {
            return back()->with('error', 'Lokasi file PDF belum tersimpan pada pengajuan.');
        }

        if (!Storage::disk('public')->exists($fileSurat)) {
            return back()->with('error', 'File PDF tidak ditemukan pada lokasi: ' . $fileSurat);
        }
    }

    $pengajuanSurat->update([
        'status' => $validated['status'],
        'catatan_admin' => $validated['status'] === 'ditolak'
            ? ($validated['catatan_admin'] ?? 'Pengajuan ditolak oleh admin.')
            : null,
        'tanggal_diproses' => now(),
        'tanggal_selesai' => $validated['status'] === 'selesai' ? now() : null,
    ]);

    return redirect()
        ->route('admin.pengajuan-surats.show', $pengajuanSurat)
        ->with(
            'success',
            $validated['status'] === 'selesai'
                ? 'Pengajuan berhasil disetujui. Mahasiswa dapat mengunduh surat.'
                : 'Pengajuan berhasil ditolak.'
        );
}



}