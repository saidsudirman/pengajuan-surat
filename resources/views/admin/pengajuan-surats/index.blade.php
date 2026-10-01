@extends('layouts.admin')

@section('title', 'Pengajuan Surat')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1>Pengajuan Surat</h1>
            <p>Kelola dan verifikasi pengajuan surat akademik mahasiswa.</p>
        </div>
        <button class="btn-primary-custom">
            <i class="fa-solid fa-file-export"></i> Export Data
        </button>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.pengajuan-surats.index') }}" method="GET" id="filterForm">
        <div class="card-custom p-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="filter-label">Cari</label>
                    <div class="search-wrapper" style="flex: none;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nama / NIM / Nomor Pengajuan">
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Status</label>
                    <select name="status" class="form-select-custom">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak"  {{ request('status') === 'ditolak'  ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai"  {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Jenis Surat</label>
                    <select name="jenis_surat_id" class="form-select-custom">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisSurats ?? [] as $js)
                            <option value="{{ $js->id }}" {{ request('jenis_surat_id') == $js->id ? 'selected' : '' }}>
                                {{ $js->nama_surat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-select-custom">
                </div>

                <div class="col-lg-2 col-md-12 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-primary-custom flex-grow-1 justify-content-center">
                        <i class="fa-solid fa-filter"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.pengajuan-surats.index') }}" class="btn-outline-custom" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="card-custom">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nomor Pengajuan</th>
                        <th>Mahasiswa</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th style="width: 130px;">Status</th>
                        <th style="width: 140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengajuans as $pengajuan)
                    @php
                        $statusMap = [
                            'menunggu' => ['class' => 'badge-menunggu', 'label' => 'Menunggu'],
                            'diproses' => ['class' => 'badge-diproses', 'label' => 'Diproses'],
                            'diterima' => ['class' => 'badge-diterima', 'label' => 'Diterima'],
                            'ditolak'  => ['class' => 'badge-ditolak',  'label' => 'Ditolak'],
                            'selesai'  => ['class' => 'badge-selesai',  'label' => 'Selesai'],
                        ];
                        $st = $statusMap[$pengajuan->status] ?? $statusMap['menunggu'];
                    @endphp
                    <tr>
                        <td>
                            <span class="fw-semibold text-muted">
                                {{ $pengajuans->firstItem() + $loop->index }}
                            </span>
                        </td>

                        <td>
                            <span class="nomor-pengajuan">{{ $pengajuan->nomor_pengajuan }}</span>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar" style="width: 38px; height: 38px; font-size: 13px;">
                                    {{ strtoupper(substr($pengajuan->mahasiswa->nama ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="color: var(--dark); font-size: 13.5px;">
                                        {{ $pengajuan->mahasiswa->nama ?? '-' }}
                                    </div>
                                    <small class="text-muted" style="font-size: 11.5px;">
                                        {{ $pengajuan->mahasiswa->nim ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="fw-semibold" style="font-size: 13px;">
                                {{ $pengajuan->jenisSurat->nama_surat ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <div style="font-size: 13px; font-weight: 600; color: var(--dark);">
                                {{ $pengajuan->created_at->format('d M Y') }}
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;">
                                {{ $pengajuan->created_at->format('H:i') }} WITA
                            </small>
                        </td>

                        <td>
                            <span class="badge-status {{ $st['class'] }}">
                                <span class="dot"></span>
                                {{ $st['label'] }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.pengajuan-surats.show', $pengajuan) }}"
                                   class="btn-action btn-action-view" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Belum Ada Pengajuan</h6>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    Belum ada pengajuan surat dari mahasiswa.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuans->hasPages())
        <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2" style="border-color: var(--slate-200) !important;">
            <small class="text-muted">
                Menampilkan {{ $pengajuans->firstItem() }}–{{ $pengajuans->lastItem() }}
                dari {{ $pengajuans->total() }} pengajuan
            </small>
            {{ $pengajuans->links() }}
        </div>
        @endif
    </div>

</div>

@endsection

@section('styles')
<style>
    .filter-label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 8px;
    }

    .form-select-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--slate-200);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        background: white;
        outline: none;
        transition: all 0.2s;
    }

    .form-select-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(201, 180, 88, 0.15);
    }

    .nomor-pengajuan {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .badge-status .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-menunggu { background: #FEF3C7; color: #B45309; }
    .badge-diproses { background: #DBEAFE; color: #1D4ED8; }
    .badge-diterima { background: #E0E7FF; color: #4338CA; }
    .badge-ditolak  { background: #FEE2E2; color: #B91C1C; }
    .badge-selesai  { background: #D1FAE5; color: #047857; }

    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid var(--slate-200);
        background: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12.5px;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-action-view { color: #2563EB; }
    .btn-action-view:hover {
        background: #DBEAFE;
        border-color: #93C5FD;
        color: #1D4ED8;
        transform: translateY(-1px);
    }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state-icon {
        width: 72px; height: 72px;
        margin: 0 auto 16px;
        border-radius: 20px;
        background: var(--slate-100);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; color: var(--slate-400);
    }

    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 3px;
        border: 1px solid var(--slate-200);
        color: var(--slate-700);
        font-size: 13px; font-weight: 500;
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