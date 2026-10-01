<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan relasi user
        $query = Mahasiswa::with('user');

        // Filter: Search (Nama, NIM, atau Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter: Program Studi
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }

        // Urutkan & paginate (withQueryString agar filter tetap saat pindah halaman)
        $mahasiswas = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // Ambil daftar program studi unik untuk dropdown filter
        $programStudis = Mahasiswa::query()
            ->whereNotNull('program_studi')
            ->distinct()
            ->orderBy('program_studi')
            ->pluck('program_studi');

        return view('admin.mahasiswa.index', compact('mahasiswas', 'programStudis'));
    }


    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|max:30|unique:mahasiswa,nim',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'fakultas' => 'nullable|string|max:150',
            'program_studi' => 'required|string|max:150',
            'angkatan' => 'nullable|string|max:10',
            'semester' => 'nullable|string|max:20',
            'tahun_akademik' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'mahasiswa',
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'fakultas' => $validated['fakultas'] ?? null,
                'program_studi' => $validated['program_studi'],
                'angkatan' => $validated['angkatan'] ?? null,
                'semester' => $validated['semester'] ?? null,
                'tahun_akademik' => $validated['tahun_akademik'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa dan akun login berhasil dibuat.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user');

        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:users,email,' . $mahasiswa->user_id,
            'password' => 'nullable|string|min:8|confirmed',
            'nim' => 'required|string|max:30|unique:mahasiswa,nim,' . $mahasiswa->id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'fakultas' => 'nullable|string|max:150',
            'program_studi' => 'required|string|max:150',
            'angkatan' => 'nullable|string|max:10',
            'semester' => 'nullable|string|max:20',
            'tahun_akademik' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {

            $user = $mahasiswa->user;

            $userData = [
                'name' => $validated['nama'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            $mahasiswa->update([
                'nim' => $validated['nim'],
                'nama' => $validated['nama'],
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'fakultas' => $validated['fakultas'] ?? null,
                'program_studi' => $validated['program_studi'],
                'angkatan' => $validated['angkatan'] ?? null,
                'semester' => $validated['semester'] ?? null,
                'tahun_akademik' => $validated['tahun_akademik'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->pengajuanSurats()->exists()) {
            return redirect()
                ->route('admin.mahasiswa.index')
                ->with(
                    'error',
                    'Mahasiswa tidak dapat dihapus karena sudah memiliki pengajuan surat.'
                );
        }

        DB::transaction(function () use ($mahasiswa) {

            $user = $mahasiswa->user;

            $mahasiswa->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa dan akun login berhasil dihapus.');
    }
}