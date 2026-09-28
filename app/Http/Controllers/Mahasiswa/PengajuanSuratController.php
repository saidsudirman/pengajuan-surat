<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\DetailPengajuan;
use App\Models\DokumenPengajuan;
use App\Models\RiwayatPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanSuratController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $pengajuans = PengajuanSurat::with([
            'jenisSurat',
            'detailPengajuan',
            'dokumenPengajuans',
            'riwayatPengajuans',
        ])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->paginate(10);

        return view('mahasiswa.pengajuan-surats.index', compact('pengajuans'));
    }

    public function create()
    {
        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view(
            'mahasiswa.pengajuan-surats.create',
            compact('jenisSurats')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan' => 'required|string',
            'file_persyaratan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan.');
        }

        DB::transaction(function () use ($request, $validated, $mahasiswa) {

            $filePersyaratan = null;

            if ($request->hasFile('file_persyaratan')) {
                $filePersyaratan = $request->file('file_persyaratan')
                    ->store('persyaratan', 'public');
            }

            $pengajuan = PengajuanSurat::create([
                'mahasiswa_id' => $mahasiswa->id,
                'jenis_surat_id' => $validated['jenis_surat_id'],
                'nomor_pengajuan' => 'PGJ-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'keperluan' => $validated['keperluan'],
                'status' => 'menunggu',
                'file_persyaratan' => $filePersyaratan,
            ]);

            DetailPengajuan::create([
                'pengajuan_surat_id' => $pengajuan->id,
                'nama_mahasiswa' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'program_studi' => $mahasiswa->program_studi,
                'fakultas' => $mahasiswa->fakultas,
                'semester' => $mahasiswa->semester,
                'tahun_akademik' => $mahasiswa->tahun_akademik,
            ]);

            RiwayatPengajuan::create([
                'pengajuan_surat_id' => $pengajuan->id,
                'status' => 'menunggu',
                'catatan' => 'Pengajuan surat dibuat oleh mahasiswa.',
            ]);
        });

        return redirect()
            ->route('mahasiswa.pengajuan-surats.index')
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function show(PengajuanSurat $pengajuanSurat)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa || $pengajuanSurat->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $pengajuanSurat->load([
            'jenisSurat',
            'detailPengajuan',
            'dokumenPengajuans',
            'riwayatPengajuans',
        ]);

        return view(
            'mahasiswa.pengajuan-surats.show',
            compact('pengajuanSurat')
        );
    }
}