<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\RiwayatPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanSurat::with([
            'mahasiswa',
            'jenisSurat',
        ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.pengajuan-surats.index',
            compact('pengajuans')
        );
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
            'status' => 'required|in:menunggu,diproses,diterima,ditolak,selesai',
            'catatan_admin' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use (
            $request,
            $validated,
            $pengajuanSurat
        ) {

            $data = [
                'status' => $validated['status'],
                'catatan_admin' => $validated['catatan_admin'] ?? null,
            ];

            if (
                $validated['status'] === 'diproses' &&
                $pengajuanSurat->tanggal_diproses === null
            ) {
                $data['tanggal_diproses'] = now();
            }

            if (
                $validated['status'] === 'selesai' &&
                $pengajuanSurat->tanggal_selesai === null
            ) {
                $data['tanggal_selesai'] = now();
            }

            if ($request->hasFile('file_surat')) {
                $data['file_surat'] = $request->file('file_surat')
                    ->store('surat', 'public');
            }

            $pengajuanSurat->update($data);

            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuanSurat->id,
                'status' => $validated['status'],
                'catatan' => $validated['catatan_admin'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.pengajuan-surats.show', $pengajuanSurat)
            ->with('success', 'Pengajuan surat berhasil diperbarui.');
    }
}