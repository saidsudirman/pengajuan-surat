<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = JenisSurat::query();

        // Filter: Search (nama_surat atau deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_surat', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan & paginate (with query string agar filter tetap saat pindah halaman)
        $jenisSurats = $query->latest()
            ->paginate(10)
            ->withQueryString();

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