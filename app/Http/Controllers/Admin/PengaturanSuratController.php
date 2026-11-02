<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSuratController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSurat::firstOrCreate(
            ['id' => 1],
            ['nama_universitas' => 'Universitas Dipa Makassar']
        );

        return view('admin.pengaturan-surat.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanSurat::firstOrCreate(
            ['id' => 1],
            ['nama_universitas' => 'Universitas Dipa Makassar']
        );

        $validated = $request->validate([
            'nama_yayasan' => 'nullable|string|max:255',
            'nama_universitas' => 'required|string|max:255',
            'nama_unit' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'jabatan_pejabat' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'stempel' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        foreach (['logo', 'tanda_tangan', 'stempel'] as $field) {
            if ($request->hasFile($field)) {
                if ($pengaturan->$field) {
                    Storage::disk('public')->delete($pengaturan->$field);
                }

                $validated[$field] = $request->file($field)
                    ->store('pengaturan-surat', 'public');
            }
        }

        $pengaturan->update($validated);

        return redirect()
            ->route('admin.pengaturan-surat.index')
            ->with('success', 'Pengaturan surat berhasil diperbarui.');
    }
}
