<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan.');
        }

        $total    = PengajuanSurat::where('mahasiswa_id', $mahasiswa->id)->count();
        $menunggu = PengajuanSurat::where('mahasiswa_id', $mahasiswa->id)->where('status', 'menunggu')->count();
        $diproses = PengajuanSurat::where('mahasiswa_id', $mahasiswa->id)->where('status', 'diproses')->count();
        $selesai  = PengajuanSurat::where('mahasiswa_id', $mahasiswa->id)->where('status', 'selesai')->count();

        $pengajuans = PengajuanSurat::with('jenisSurat')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'total', 'menunggu', 'diproses', 'selesai', 'pengajuans'
        ));
    }
}