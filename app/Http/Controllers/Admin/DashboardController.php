<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengajuan = PengajuanSurat::count();
        $menunggu       = PengajuanSurat::where('status', 'menunggu')->count();
        $diproses       = PengajuanSurat::where('status', 'diproses')->count();
        $ditolak        = PengajuanSurat::where('status', 'ditolak')->count();
        $selesai        = PengajuanSurat::where('status', 'selesai')->count();

        $bulanIni       = Carbon::now()->startOfMonth();
        $bulanLalu      = Carbon::now()->subMonth()->startOfMonth();
        $akhirBulanLalu = Carbon::now()->subMonth()->endOfMonth();

        $trendTotal    = $this->hitungTrend(
            PengajuanSurat::where('created_at', '>=', $bulanIni)->count(),
            PengajuanSurat::whereBetween('created_at', [$bulanLalu, $akhirBulanLalu])->count()
        );

        $trendMenunggu = $this->hitungTrend(
            PengajuanSurat::where('status', 'menunggu')->where('created_at', '>=', $bulanIni)->count(),
            PengajuanSurat::where('status', 'menunggu')->whereBetween('created_at', [$bulanLalu, $akhirBulanLalu])->count()
        );

        $trendDiproses = $this->hitungTrend(
            PengajuanSurat::where('status', 'diproses')->where('created_at', '>=', $bulanIni)->count(),
            PengajuanSurat::where('status', 'diproses')->whereBetween('created_at', [$bulanLalu, $akhirBulanLalu])->count()
        );

        $trendSelesai  = $this->hitungTrend(
            PengajuanSurat::where('status', 'selesai')->where('created_at', '>=', $bulanIni)->count(),
            PengajuanSurat::where('status', 'selesai')->whereBetween('created_at', [$bulanLalu, $akhirBulanLalu])->count()
        );

        $trendDitolak  = $this->hitungTrend(
            PengajuanSurat::where('status', 'ditolak')->where('created_at', '>=', $bulanIni)->count(),
            PengajuanSurat::where('status', 'ditolak')->whereBetween('created_at', [$bulanLalu, $akhirBulanLalu])->count()
        );

        return view('admin.dashboard', compact(
            'totalPengajuan', 'menunggu', 'diproses', 'ditolak', 'selesai',
            'trendTotal', 'trendMenunggu', 'trendDiproses', 'trendSelesai', 'trendDitolak'
        ));
    }

    private function hitungTrend(int $sekarang, int $sebelumnya): array
    {
        if ($sebelumnya === 0 && $sekarang === 0) {
            return ['arah' => 'neutral', 'icon' => 'minus', 'text' => 'Belum ada data'];
        }

        if ($sebelumnya === 0) {
            return ['arah' => 'up', 'icon' => 'arrow-up', 'text' => 'Data baru bulan ini'];
        }

        $selisih = (($sekarang - $sebelumnya) / $sebelumnya) * 100;
        $persen  = round(abs($selisih), 1);

        if ($selisih > 0) {
            return ['arah' => 'up', 'icon' => 'arrow-up', 'text' => $persen . '% dari bulan lalu'];
        } elseif ($selisih < 0) {
            return ['arah' => 'down', 'icon' => 'arrow-down', 'text' => $persen . '% dari bulan lalu'];
        }

        return ['arah' => 'neutral', 'icon' => 'minus', 'text' => 'Sama dengan bulan lalu'];
    }
}