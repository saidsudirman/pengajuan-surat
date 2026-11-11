<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanAkademikController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanAkademik::aktif();

        return view('admin.pengaturan-akademik.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tahun_akademik' => [
                'required',
                'regex:/^\d{4}\/\d{4}$/',
            ],
            'semester_aktif' => 'required|in:Ganjil,Genap',
        ], [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.regex' => 'Format tahun akademik harus seperti 2026/2027.',
            'semester_aktif.required' => 'Semester aktif wajib dipilih.',
            'semester_aktif.in' => 'Semester aktif tidak valid.',
        ]);

        [$tahunMulai, $tahunSelesai] = explode('/', $validated['tahun_akademik']);

        if ((int) $tahunSelesai !== (int) $tahunMulai + 1) {
            return back()
                ->withErrors([
                    'tahun_akademik' => 'Tahun akademik harus berurutan, contoh 2026/2027.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($validated) {
            PengaturanAkademik::query()->update([
                'status' => false,
            ]);

            $pengaturan = PengaturanAkademik::first();

            if ($pengaturan) {
                $pengaturan->update([
                    ...$validated,
                    'status' => true,
                ]);
            } else {
                PengaturanAkademik::create([
                    ...$validated,
                    'status' => true,
                ]);
            }
        });

        return redirect()
            ->route('admin.pengaturan-akademik.index')
            ->with('success', 'Pengaturan tahun akademik berhasil diperbarui.');
    }
}
