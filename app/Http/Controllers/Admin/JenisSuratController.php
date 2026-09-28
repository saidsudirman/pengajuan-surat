<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurats = JenisSurat::latest()->paginate(10);

        return view('admin.jenis-surats.index', compact('jenisSurats'));
    }

    public function create()
    {
        return view('admin.jenis-surats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        JenisSurat::create($validated);

        return redirect()
            ->route('admin.jenis-surats.index')
            ->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    public function edit(JenisSurat $jenisSurat)
    {
        return view('admin.jenis-surats.edit', compact('jenisSurat'));
    }

    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'nama_surat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $jenisSurat->update($validated);

        return redirect()
            ->route('admin.jenis-surats.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat)
    {
        if ($jenisSurat->pengajuanSurats()->exists()) {
            return redirect()
                ->route('admin.jenis-surats.index')
                ->with('error', 'Jenis surat tidak dapat dihapus karena sudah digunakan pada pengajuan.');
        }

        $jenisSurat->delete();

        return redirect()
            ->route('admin.jenis-surats.index')
            ->with('success', 'Jenis surat berhasil dihapus.');
    }
}