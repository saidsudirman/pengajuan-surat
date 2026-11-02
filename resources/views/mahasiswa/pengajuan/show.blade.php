@extends('layouts.mahasiswa')

@section('title', 'Detail Pengajuan')
@section('subtitle', 'Detail informasi pengajuan')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header-mhs d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="breadcrumb-mhs mb-2">
                <a href="{{ route('mahasiswa.pengajuan.index') }}">Riwayat Pengajuan</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Detail</span>
            </div>
            <h1>Detail Pengajuan</h1>
            <p>Nomor: <strong class="text-primary-mhs">{{ $pengajuan->nomor_pengajuan }}</strong></p>
        </div>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn-mhs-outline">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @php
        $statusMap = [
            'menunggu' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'diterima' => 'Disetujui',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $statusKey = $pengajuan->status;
        $statusText = $statusMap[$statusKey] ?? 'Tidak Diketahui';

        $steps = [
            ['label' => 'Pengajuan', 'icon' => 'fa-paper-plane', 'done' => true],
            ['label' => 'Verifikasi', 'icon' => 'fa-check', 'done' => in_array($statusKey, ['diproses', 'diterima', 'selesai'])],
            ['label' => 'Persetujuan', 'icon' => 'fa-user-check', 'done' => in_array($statusKey, ['diterima', 'selesai'])],
            ['label' => 'Selesai', 'icon' => 'fa-circle-check', 'done' => $statusKey === 'selesai'],
        ];
    @endphp

    {{-- Header Card --}}
    <div class="card-mhs p-3 p-md-4 mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="detail-header-icon">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <div class="fw-bold detail-header-title">
                        {{ $pengajuan->jenisSurat->nama_surat ?? '-' }}
                    </div>
                    <small class="text-muted detail-header-date">
                        Diajukan: {{ $pengajuan->created_at?->format('d F Y, H:i') ?? '-' }}
                    </small>
                </div>
            </div>

            <span class="badge-status-mhs badge-status-{{ $statusKey }} badge-status-lg">
                <span class="dot"></span>
                {{ $statusText }}
            </span>
        </div>
    </div>

    <div class="row g-3">
        {{-- KOLOM KIRI --}}
        <div class="col-lg-8">

            {{-- Timeline --}}
            <div class="card-mhs p-3 p-md-4 mb-3">
                <h6 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-timeline text-primary-mhs"></i>
                    Timeline Status
                </h6>

                <div class="timeline-horizontal">
                    @foreach($steps as $step)
                        <div class="timeline-step {{ $step['done'] ? 'done' : '' }}">
                            <div class="timeline-icon">
                                <i class="fa-solid {{ $step['icon'] }}"></i>
                            </div>
                            <div class="timeline-label">
                                {{ $step['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($statusKey === 'ditolak')
                    <div class="catatan-admin-box mt-4">
                        <div class="catatan-admin-label">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Pengajuan Ditolak
                        </div>
                        <div class="catatan-admin-value">
                            {{ $pengajuan->catatan_admin ?? 'Silakan hubungi admin untuk informasi lebih lanjut.' }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- Informasi Pengajuan --}}
            <div class="card-mhs p-3 p-md-4 mb-3">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-info text-primary-mhs"></i>
                    Informasi Pengajuan
                </h6>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-block">
                            <div class="detail-block-label">Nomor Pengajuan</div>
                            <div class="detail-block-value">{{ $pengajuan->nomor_pengajuan }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-block">
                            <div class="detail-block-label">Jenis Surat</div>
                            <div class="detail-block-value">{{ $pengajuan->jenisSurat->nama_surat ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-block">
                            <div class="detail-block-label">Tanggal Pengajuan</div>
                            <div class="detail-block-value">{{ $pengajuan->created_at->format('d F Y') }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="detail-block">
                            <div class="detail-block-label">Keperluan</div>
                            <div class="detail-block-value">{{ $pengajuan->keperluan }}</div>
                        </div>
                    </div>
                </div>

                @if($pengajuan->catatan_admin && $statusKey !== 'ditolak')
                    <div class="catatan-admin-box">
                        <div class="catatan-admin-label">
                            <i class="fa-solid fa-comment"></i> Catatan Admin
                        </div>
                        <div class="catatan-admin-value">{{ $pengajuan->catatan_admin }}</div>
                    </div>
                @endif
            </div>

            {{-- Data Tambahan --}}
            @if($pengajuan->detailPengajuan && !empty($pengajuan->detailPengajuan->data_tambahan))
                <div class="card-mhs p-3 p-md-4 mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-list-check text-primary-mhs"></i>
                        Data Tambahan Pengajuan
                    </h6>

                    <div class="row g-3">
                        @foreach($pengajuan->jenisSurat->fieldSurats as $field)
                            @php
                                $data = $pengajuan->detailPengajuan->data_tambahan ?? [];
                                $value = $data[$field->nama_field] ?? null;
                            @endphp

                            @if($value !== null && $value !== '')
                                <div class="col-md-6">
                                    <div class="detail-block">
                                        <div class="detail-block-label">{{ $field->label }}</div>
                                        <div class="detail-block-value">{{ $value }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Dokumen Pendukung --}}
            @if($pengajuan->dokumenPengajuans->count() > 0)
                <div class="card-mhs p-3 p-md-4 mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-paperclip text-primary-mhs"></i>
                        Dokumen Pendukung
                    </h6>

                    <div class="row g-2">
                        @foreach($pengajuan->dokumenPengajuans as $dok)
                            <div class="col-md-6">
                                <div class="dokumen-item">
                                    <div class="dokumen-icon">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </div>

                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-bold text-truncate dokumen-nama">
                                            {{ $dok->nama_dokumen }}
                                        </div>

                                        <small class="text-muted dokumen-ukuran">
                                            @if($dok->status === 'valid')
                                                <span class="text-success">Dokumen Valid</span>
                                            @elseif($dok->status === 'tidak_valid')
                                                <span class="text-danger">Dokumen Tidak Valid</span>
                                            @else
                                                <span class="text-warning">Menunggu Pemeriksaan</span>
                                            @endif
                                        </small>

                                        @if($dok->keterangan)
                                            <div class="small text-muted mt-1">
                                                {{ $dok->keterangan }}
                                            </div>
                                        @endif
                                    </div>

                                    <a href="{{ Storage::disk('public')->url($dok->file) }}" target="_blank" rel="noopener noreferrer" class="btn-icon-doc" title="Lihat dokumen">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Riwayat Pengajuan (Dipindah ke kolom kiri agar rapi) --}}
            @if($pengajuan->riwayatPengajuans->count() > 0)
                <div class="card-mhs p-3 p-md-4 mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-primary-mhs"></i>
                        Riwayat Aktivitas
                    </h6>

                    <div class="timeline-vertical">
                        @foreach($pengajuan->riwayatPengajuans->sortBy('created_at') as $riwayat)
                            <div class="timeline-vertical-item">
                                <div class="timeline-vertical-dot"></div>
                                <div class="timeline-vertical-content">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                                        <strong class="text-capitalize" style="font-size: 13.5px;">
                                            {{ str_replace('_', ' ', $riwayat->status) }}
                                        </strong>
                                        <small class="text-muted" style="font-size: 11.5px;">
                                            {{ $riwayat->created_at?->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <div class="small text-muted mb-1">
                                        {{ $riwayat->catatan ?? '-' }}
                                    </div>
                                    <div class="small" style="color: var(--primary-dark); font-weight: 600;">
                                        <i class="fa-solid fa-user-circle me-1"></i> {{ $riwayat->user->name ?? 'Sistem' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        {{-- KOLOM KANAN (Sidebar) --}}
        <div class="col-lg-4">
            {{-- Data Mahasiswa --}}
            <div class="card-mhs p-3 p-md-4 mb-3">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-user text-primary-mhs"></i>
                    Data Mahasiswa
                </h6>

                <div class="info-row">
                    <small class="info-row-label">Nama</small>
                    <div class="info-row-value">{{ $pengajuan->mahasiswa->nama ?? '-' }}</div>
                </div>

                <div class="info-row">
                    <small class="info-row-label">NIM</small>
                    <div class="info-row-value">{{ $pengajuan->mahasiswa->nim ?? '-' }}</div>
                </div>

                <div class="info-row-last">
                    <small class="info-row-label">Program Studi</small>
                    <div class="info-row-value">{{ $pengajuan->mahasiswa->program_studi ?? '-' }}</div>
                </div>
            </div>

            {{-- Batalkan Pengajuan --}}
            @if($pengajuan->status === 'menunggu')
                <div class="card-mhs p-3 p-md-4 mb-3">
                    <h6 class="fw-bold mb-2 d-flex align-items-center gap-2 text-danger-mhs">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Batalkan Pengajuan
                    </h6>
                    <p class="text-muted mb-3 info-hint">
                        Pengajuan masih menunggu verifikasi. Anda dapat membatalkannya jika salah mengajukan.
                    </p>
                    <form action="{{ route('mahasiswa.pengajuan.cancel', $pengajuan) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-mhs-outline w-100 btn-danger-soft">
                            <i class="fa-solid fa-xmark"></i> Batalkan Pengajuan
                        </button>
                    </form>
                </div>
            @endif

            {{-- Download Surat --}}
            @if($pengajuan->status === 'selesai' && $pengajuan->file_surat)
                <div class="card-mhs p-3 p-md-4 card-success">
                    <h6 class="fw-bold mb-2 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        Surat Siap Diunduh
                    </h6>

                    <p class="mb-3 card-success-text">
                        Surat Anda sudah selesai dibuat dan siap diunduh.
                    </p>

                    <a href="{{ route('mahasiswa.pengajuan.download', $pengajuan) }}" class="btn-mhs-primary btn-white-solid">
                        <i class="fa-solid fa-download"></i>
                        Download Surat PDF
                    </a>
                </div>
            @elseif($pengajuan->status === 'selesai' && !$pengajuan->file_surat)
                <div class="card-mhs p-3 p-md-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fa-solid fa-circle-info text-primary-mhs"></i>
                        Surat Belum Tersedia
                    </h6>
                    <p class="text-muted mb-0 info-hint">
                        Pengajuan sudah selesai, tetapi file surat belum tersedia. Silakan hubungi admin.
                    </p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    /* Breadcrumb */
    .breadcrumb-mhs {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--slate-500);
    }
    .breadcrumb-mhs a {
        color: var(--slate-500);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .breadcrumb-mhs a:hover { color: var(--primary); }
    .breadcrumb-mhs i { font-size: 9px; color: var(--slate-400); }
    .breadcrumb-mhs span { color: var(--primary-dark); font-weight: 700; }

    .text-primary-mhs { color: var(--primary) !important; }
    .text-danger-mhs { color: #B91C1C !important; }

    /* Header Card */
    .detail-header-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .detail-header-title { font-size: 15px; }
    .detail-header-date { font-size: 12px; }

    /* Timeline Horizontal */
    .timeline-horizontal {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 0 10px;
    }
    .timeline-horizontal::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 40px;
        right: 40px;
        height: 2px;
        background: var(--slate-200);
    }
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    .timeline-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: white;
        border: 2px solid var(--slate-200);
        color: var(--slate-400);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.3s;
    }
    .timeline-step.done .timeline-icon {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 10px rgba(201, 180, 88, 0.4);
    }
    .timeline-label {
        font-size: 11.5px;
        font-weight: 700;
        color: var(--slate-500);
        text-align: center;
    }
    .timeline-step.done .timeline-label { color: var(--primary-dark); }

    /* Timeline Vertikal (Riwayat) */
    .timeline-vertical {
        position: relative;
        padding-left: 20px;
        border-left: 2px solid var(--slate-200);
        margin-left: 10px;
    }
    .timeline-vertical-item {
        position: relative;
        margin-bottom: 20px;
    }
    .timeline-vertical-item:last-child {
        margin-bottom: 0;
    }
    .timeline-vertical-dot {
        position: absolute;
        left: -27px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary);
        border: 2px solid white;
        box-shadow: 0 0 0 2px var(--primary-light);
    }
    .timeline-vertical-content {
        background: var(--slate-100);
        padding: 12px 16px;
        border-radius: 10px;
    }

    /* Detail Block */
    .detail-block { padding: 8px 0; }
    .detail-block-label {
        font-size: 11px;
        color: var(--slate-500);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .detail-block-value {
        font-size: 13.5px;
        color: var(--dark);
        font-weight: 600;
        line-height: 1.5;
    }

    /* Catatan Admin */
    .catatan-admin-box {
        margin-top: 16px;
        padding: 14px;
        background: var(--primary-light);
        border-radius: 10px;
        border-left: 3px solid var(--primary);
    }
    .catatan-admin-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--primary-dark);
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .catatan-admin-value { font-size: 13px; }

    /* Dokumen */
    .dokumen-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: var(--slate-100);
        border-radius: 10px;
    }
    .dokumen-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .dokumen-nama { font-size: 12.5px; }
    .dokumen-ukuran { font-size: 11px; }

    /* Info Row (Sidebar) */
    .info-row {
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--slate-200);
    }
    .info-row-last { padding-bottom: 0; }
    .info-row-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }
    .info-row-value {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--dark);
    }

    /* Badge Status */
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
    .badge-status-lg { padding: 8px 16px; font-size: 12.5px; gap: 6px; }
    .badge-status-lg .dot { width: 7px; height: 7px; }

    .badge-status-menunggu { background: #FEF3C7; color: #B45309; }
    .badge-status-diproses { background: #DBEAFE; color: #1D4ED8; }
    .badge-status-diterima { background: #D1FAE5; color: #047857; }
    .badge-status-selesai  { background: #D1FAE5; color: #047857; }
    .badge-status-ditolak  { background: #FEE2E2; color: #B91C1C; }

    /* Hint text */
    .info-hint { font-size: 12.5px; line-height: 1.5; }

    /* Batalkan button */
    .btn-danger-soft { color: #DC2626; border-color: #FECACA; }
    .btn-danger-soft:hover { background: #FEF2F2; border-color: #DC2626; color: #B91C1C; }

    /* Card Success */
    .card-success {
        background: linear-gradient(135deg, #047857, #065F46);
        border: none;
        color: white;
    }
    .card-success-text { font-size: 12.5px; color: rgba(255, 255, 255, 0.9); }
    .btn-white-solid { background: white; color: #047857; box-shadow: none; }
    .btn-white-solid:hover { background: #F0FDF4; color: #047857; }

    /* Dokumen Button */
    .btn-icon-doc {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: white;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        text-decoration: none;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .btn-icon-doc:hover { background: var(--primary); color: white; }

    /* Responsive */
    @media (max-width: 575.98px) {
        .timeline-horizontal { flex-direction: column; gap: 16px; padding: 0; }
        .timeline-horizontal::before { display: none; }
        .timeline-step { flex-direction: row; justify-content: flex-start; gap: 12px; }
        .timeline-label { text-align: left; }
    }
</style>
@endsection