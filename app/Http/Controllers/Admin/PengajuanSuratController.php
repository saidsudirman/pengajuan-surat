<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\User;
use App\Models\PengajuanSurat;
use App\Models\RiwayatPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanSurat::with(['mahasiswa', 'jenisSurat']);

        // Filter: Search (nama mahasiswa / NIM / nomor pengajuan)
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

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Jenis Surat
        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        // Filter: Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Ambil data + pagination + dengan query string (filter tetap saat pindah halaman)
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
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string|max:500',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'status' => $request->status,
                'catatan_admin' => $request->catatan,
            ];

            // Update tanggal
            if ($request->status === 'diproses' && !$pengajuanSurat->tanggal_diproses) {
                $data['tanggal_diproses'] = now();
            }

            if ($request->status === 'selesai' && !$pengajuanSurat->tanggal_selesai) {
                $data['tanggal_selesai'] = now();
            }

            // Upload file surat
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');
                $filename = 'surat_' . $pengajuanSurat->nomor_pengajuan . '_' . time() . '.pdf';
                $data['file_surat'] = $file->storeAs('surat', $filename, 'public');
            }

            // Update pengajuan
            $pengajuanSurat->update($data);

            // Simpan riwayat
            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuanSurat->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'status' => $request->status,
                'catatan' => $request->catatan ?? '-',
            ]);

            DB::commit();

            return back()->with('success', 'Pengajuan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}