<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\FieldSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JenisSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = JenisSurat::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_surat', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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
        $fields = collect($request->input('fields', []))
            ->filter(fn ($field) => filled($field['label'] ?? null)
                && filled($field['nama_field'] ?? null))
            ->values()
            ->all();

        $validated = $request->validate([
            'nama_surat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string|max:255',
            'isi_template' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',

            'fields' => 'nullable|array',
            'fields.*.label' => 'required|string|max:150',
            'fields.*.nama_field' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z][a-z0-9_]*$/',
            ],
            'fields.*.tipe' => 'required|in:text,textarea,date,number,email',
            'fields.*.wajib_diisi' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $fields) {
            $jenisSurat = JenisSurat::create([
                'nama_surat' => $validated['nama_surat'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'template_surat' => $validated['template_surat'] ?? null,
                'isi_template' => $validated['isi_template'],
                'status' => $validated['status'],
            ]);

            foreach ($fields as $index => $field) {
                $jenisSurat->fieldSurats()->create([
                    'label' => $field['label'],
                    'nama_field' => $field['nama_field'],
                    'tipe' => $field['tipe'],
                    'wajib_diisi' => isset($field['wajib_diisi']),
                    'urutan' => $index + 1,
                ]);
            }
        });

        return redirect()
            ->route('admin.jenis-surats.index')
            ->with('success', 'Jenis surat dan template berhasil ditambahkan.');
    }

    public function edit(JenisSurat $jenisSurat)
    {
        $jenisSurat->load('fieldSurats');

        return view('admin.jenis-surats.edit', compact('jenisSurat'));
    }

    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $fields = collect($request->input('fields', []))
            ->filter(fn ($field) => filled($field['label'] ?? null)
                && filled($field['nama_field'] ?? null))
            ->values()
            ->all();

        $validated = $request->validate([
            'nama_surat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'template_surat' => 'nullable|string|max:255',
            'isi_template' => 'required|string',
            'status' => 'required|in:aktif,tidak_aktif',

            'fields' => 'nullable|array',
            'fields.*.label' => 'required|string|max:150',
            'fields.*.nama_field' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z][a-z0-9_]*$/',
            ],
            'fields.*.tipe' => 'required|in:text,textarea,date,number,email',
            'fields.*.wajib_diisi' => 'nullable|boolean',
        ]);

        $namaFields = array_column($fields, 'nama_field');

        if (count($namaFields) !== count(array_unique($namaFields))) {
            return back()
                ->withInput()
                ->withErrors([
                    'fields' => 'Nama field tidak boleh sama dalam satu jenis surat.',
                ]);
        }

        DB::transaction(function () use ($validated, $fields, $jenisSurat, $request) {
            $jenisSurat->update([
                'nama_surat' => $validated['nama_surat'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'template_surat' => $validated['template_surat'] ?? null,
                'isi_template' => $validated['isi_template'],
                'status' => $validated['status'],
            ]);

            if ($request->has('fields')) {
                $jenisSurat->fieldSurats()->delete();

                foreach ($fields as $index => $field) {
                    $jenisSurat->fieldSurats()->create([
                        'label' => $field['label'],
                        'nama_field' => $field['nama_field'],
                        'tipe' => $field['tipe'],
                        'wajib_diisi' => isset($field['wajib_diisi']),
                        'urutan' => $index + 1,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.jenis-surats.index')
            ->with('success', 'Jenis surat dan template berhasil diperbarui.');
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
