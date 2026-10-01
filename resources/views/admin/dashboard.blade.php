@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid p-0">

    {{-- Greeting Banner --}}
    <div class="greeting-banner">
        <h2>Selamat Datang, {{ auth()->user()->name }} 👋</h2>
        <p>Kelola pengajuan surat akademik mahasiswa dengan lebih mudah dan efisien.</p>
    </div>

    {{-- Statistic Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $totalPengajuan }}</div>
                        <div class="stat-label">Total Pengajuan</div>
                    </div>
                    <div class="stat-icon red">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </div>
                </div>
                <span class="stat-trend {{ $trendTotal['arah'] }}">
                    <i class="fa-solid fa-{{ $trendTotal['icon'] }}"></i> {{ $trendTotal['text'] }}
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $menunggu }}</div>
                        <div class="stat-label">Menunggu Verifikasi</div>
                    </div>
                    <div class="stat-icon orange">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
                <span class="stat-trend {{ $trendMenunggu['arah'] }}">
                    <i class="fa-solid fa-{{ $trendMenunggu['icon'] }}"></i> {{ $trendMenunggu['text'] }}
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $diproses }}</div>
                        <div class="stat-label">Sedang Diproses</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fa-solid fa-spinner"></i>
                    </div>
                </div>
                <span class="stat-trend {{ $trendDiproses['arah'] }}">
                    <i class="fa-solid fa-{{ $trendDiproses['icon'] }}"></i> {{ $trendDiproses['text'] }}
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $selesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <span class="stat-trend {{ $trendSelesai['arah'] }}">
                    <i class="fa-solid fa-{{ $trendSelesai['icon'] }}"></i> {{ $trendSelesai['text'] }}
                </span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <div class="stat-value">{{ $ditolak }}</div>
                        <div class="stat-label">Ditolak</div>
                    </div>
                    <div class="stat-icon gray">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <span class="stat-trend {{ $trendDitolak['arah'] }}">
                    <i class="fa-solid fa-{{ $trendDitolak['icon'] }}"></i> {{ $trendDitolak['text'] }}
                </span>
            </div>
        </div>
    </div>

</div>

@endsection