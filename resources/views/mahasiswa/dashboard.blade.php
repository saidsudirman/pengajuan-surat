@extends('layouts.mahasiswa')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang kembali!')

@section('content')

<div class="container-fluid p-0">

    {{-- Greeting Banner --}}
    <div class="greeting-banner-mhs mb-4">
        <div class="greeting-banner-circle-1"></div>
        <div class="greeting-banner-circle-2"></div>

        <div class="greeting-content">
            <h2 class="greeting-title">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h2>
            <p class="greeting-subtitle d-none d-md-block">
                Ajukan surat akademik dengan mudah, cepat, dan tanpa antre.
            </p>

            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="btn-mhs-primary btn-greeting-cta">
                <i class="fa-solid fa-plus"></i> Ajukan Surat Baru
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card-mhs p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-mhs stat-icon-gold">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $total }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card-mhs p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-mhs stat-icon-orange">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $menunggu }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card-mhs p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-mhs stat-icon-blue">
                        <i class="fa-solid fa-spinner"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $diproses }}</div>
                        <div class="stat-label">Diproses</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card-mhs p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon-mhs stat-icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="stat-number">{{ $selesai }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengajuan Terbaru --}}
    <div class="card-mhs">
        <div class="p-3 p-md-4 border-bottom d-flex justify-content-between align-items-center section-header-mhs">
            <h6 class="fw-bold mb-0 section-title-mhs">Pengajuan Terbaru</h6>
            <a href="{{ route('mahasiswa.pengajuan.index') }}" class="section-link-mhs">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($pengajuans->count() > 0)
        <div class="p-2 p-md-3">
            @foreach($pengajuans as $p)
            <a href="{{ route('mahasiswa.pengajuan.show', $p) }}" class="pengajuan-item">
                <div class="pengajuan-item-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>

                <div class="flex-grow-1 min-w-0">
                    <div class="pengajuan-item-title text-truncate">
                        {{ $p->jenisSurat->nama_surat ?? '-' }}
                    </div>
                    <small class="text-muted pengajuan-item-sub">
                        {{ $p->nomor_pengajuan }} • {{ $p->created_at->format('d M Y') }}
                    </small>
                </div>

                <div>
                    @php
                        $statusMap = [
                            'menunggu' => 'Menunggu',
                            'diproses' => 'Diproses',
                            'selesai'  => 'Selesai',
                            'ditolak'  => 'Ditolak',
                        ];
                        $statusKey  = $p->status;
                        $statusText = $statusMap[$statusKey] ?? 'Menunggu';
                    @endphp
                    <span class="badge-status-mhs badge-status-{{ $statusKey }}">
                        <span class="dot"></span>
                        {{ $statusText }}
                    </span>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-5 text-center">
            <i class="fa-regular fa-folder-open d-block mb-3 empty-icon-mhs"></i>
            <h6 class="fw-bold mb-2">Belum Ada Pengajuan</h6>
            <p class="text-muted mb-3 empty-text-mhs">Mulai ajukan surat akademik pertama Anda.</p>
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="btn-mhs-primary">
                <i class="fa-solid fa-plus"></i> Ajukan Surat
            </a>
        </div>
        @endif
    </div>

</div>

@endsection

@section('styles')
<style>
    /* ============ GREETING BANNER ============ */
    .greeting-banner-mhs {
        position: relative;
        overflow: hidden;
        padding: 28px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .greeting-banner-circle-1 {
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .greeting-banner-circle-2 {
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 140px;
        height: 140px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .greeting-content {
        position: relative;
        z-index: 2;
    }

    .greeting-title {
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 8px;
    }

    .greeting-subtitle {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
    }

    .btn-greeting-cta {
        background: white;
        color: var(--primary-dark);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-greeting-cta:hover {
        background: white;
        color: var(--primary-dark);
    }

    /* ============ STAT CARDS ============ */
    .stat-icon-mhs {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon-gold   { background: var(--primary-light); color: var(--primary-dark); }
    .stat-icon-orange { background: #FEF3C7; color: #B45309; }
    .stat-icon-blue   { background: #DBEAFE; color: #1D4ED8; }
    .stat-icon-green  { background: #D1FAE5; color: #047857; }

    .stat-number {
        font-size: 22px;
        font-weight: 800;
        line-height: 1;
        color: var(--dark);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        margin-top: 2px;
    }

    /* ============ SECTION HEADER ============ */
    .section-header-mhs {
        border-color: var(--slate-200) !important;
    }

    .section-title-mhs {
        font-size: 14px;
    }

    .section-link-mhs {
        font-size: 12.5px;
        color: var(--primary-dark);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s;
    }

    .section-link-mhs:hover { color: var(--primary); }

    .section-link-mhs i { font-size: 11px; }

    /* ============ PENGAJUAN ITEM ============ */
    .pengajuan-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        transition: background 0.2s;
    }

    .pengajuan-item:hover {
        background: var(--slate-100);
    }

    .pengajuan-item-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .pengajuan-item-title {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2px;
    }

    .pengajuan-item-sub {
        font-size: 11.5px;
    }

    /* ============ BADGE STATUS ============ */
    .badge-status-mhs {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-status-mhs .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-status-menunggu { background: #FEF3C7; color: #B45309; }
    .badge-status-diproses { background: #DBEAFE; color: #1D4ED8; }
    .badge-status-selesai  { background: #D1FAE5; color: #047857; }
    .badge-status-ditolak  { background: #FEE2E2; color: #B91C1C; }

    /* ============ EMPTY STATE ============ */
    .empty-icon-mhs {
        font-size: 40px;
        color: var(--slate-400);
        opacity: 0.5;
    }

    .empty-text-mhs {
        font-size: 13px;
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 575.98px) {
        .greeting-banner-mhs { padding: 20px; }
        .greeting-title { font-size: 17px; }
        .stat-number { font-size: 20px; }
    }
</style>
@endsection