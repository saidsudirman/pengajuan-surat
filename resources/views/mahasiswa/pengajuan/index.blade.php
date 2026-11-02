@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pengajuan')
@section('subtitle', 'Semua pengajuan surat Anda')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header-mhs d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1>Riwayat Pengajuan</h1>
            <p>Lihat semua pengajuan surat akademik Anda.</p>
        </div>
        <a href="{{ route('mahasiswa.pengajuan.create') }}" class="btn-mhs-primary">
            <i class="fa-solid fa-plus"></i> Ajukan Surat Baru
        </a>
    </div>

    {{-- Filter & Search (Opsional, sesuaikan dengan route Anda) --}}
    <form action="{{ route('mahasiswa.pengajuan.index') }}" method="GET" id="filterForm">
        <div class="card-mhs p-3 p-md-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-5 col-md-6">
                    <label class="form-label fw-semibold" style="font-size: 12px; color: var(--slate-500);">
                        Cari Nomor Pengajuan
                    </label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--slate-400); font-size: 13px;"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="SRT-2024-..."
                               style="width: 100%; padding: 10px 14px 10px 40px; border: 1.5px solid var(--slate-200); border-radius: 10px; font-family: inherit; font-size: 13px; background: var(--slate-100); outline: none;">
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold" style="font-size: 12px; color: var(--slate-500);">Status</label>
                    <select name="status" class="form-select" style="border-radius: 10px; font-size: 13px; border-color: var(--slate-200);">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai"  {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak"  {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-mhs-primary flex-grow-1 justify-content-center">
                        <i class="fa-solid fa-filter"></i> Terapkan
                    </button>
                    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn-mhs-outline" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- List Pengajuan --}}
    @if($pengajuans->count() > 0)
        <div class="row g-3">
            @foreach($pengajuans as $p)
            <div class="col-12 col-lg-6">
                <a href="{{ route('mahasiswa.pengajuan.show', $p) }}"
                   class="card-mhs p-3 p-md-4 d-block text-decoration-none h-100 riwayat-card">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="riwayat-icon">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <div class="fw-bold riwayat-nomor">{{ $p->nomor_pengajuan }}</div>
                                <small class="text-muted riwayat-tanggal">
                                    {{ $p->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                        </div>

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

                    <div class="mb-2">
                        <div class="fw-bold riwayat-jenis">
                            {{ $p->jenisSurat->nama_surat ?? '-' }}
                        </div>
                        <div class="text-muted riwayat-keperluan">
                            {{ Str::limit($p->keperluan, 70) }}
                        </div>
                    </div>

                    <div class="riwayat-footer">
                        <i class="fa-solid fa-arrow-right"></i>
                        <span>Lihat Detail</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $pengajuans->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card-mhs p-5 text-center">
            <i class="fa-regular fa-folder-open d-block mb-3 empty-icon"></i>
            <h5 class="fw-bold mb-2">Belum Ada Pengajuan</h5>
            <p class="text-muted mb-3 empty-text">
                Anda belum pernah mengajukan surat akademik. Mulai sekarang!
            </p>
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="btn-mhs-primary">
                <i class="fa-solid fa-plus"></i> Ajukan Surat Baru
            </a>
        </div>
    @endif

</div>

@endsection

@section('styles')
<style>
    .riwayat-card {
        color: inherit;
        transition: all 0.25s ease;
    }

    .riwayat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary) !important;
    }

    .riwayat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .riwayat-nomor {
        font-size: 13px;
        color: var(--dark);
    }

    .riwayat-tanggal {
        font-size: 11px;
    }

    .riwayat-jenis {
        font-size: 14px;
        color: var(--dark);
    }

    .riwayat-keperluan {
        font-size: 12.5px;
    }

    .riwayat-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed var(--slate-200);
        font-size: 11.5px;
        color: var(--primary-dark);
        font-weight: 700;
    }

    .riwayat-footer i {
        font-size: 10px;
        color: var(--primary);
    }

    /* Status Badges */
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

    .empty-icon {
        font-size: 48px;
        color: var(--slate-400);
        opacity: 0.5;
    }

    .empty-text {
        font-size: 13.5px;
    }
    
    /* Pagination Custom */
    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 3px;
        border: 1px solid var(--slate-200);
        color: var(--slate-700);
        font-size: 13px;
        font-weight: 500;
        padding: 6px 12px;
    }
    .pagination .page-link:hover {
        background: var(--primary-light);
        color: var(--primary-dark);
        border-color: var(--primary);
    }
    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }
</style>
@endsection