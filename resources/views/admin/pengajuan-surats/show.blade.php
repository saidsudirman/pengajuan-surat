@extends('layouts.admin')

@section('title', 'Detail Pengajuan Surat')

@section('content')

    <div class="container-fluid p-0">

        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="breadcrumb-inline mb-2">
                    <a href="{{ route('admin.pengajuan-surats.index') }}">Pengajuan Surat</a>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span>Detail</span>
                </div>
                <h1>Detail Pengajuan Surat</h1>
                <p>Nomor: <strong style="color: var(--primary);">{{ $pengajuanSurat->nomor_pengajuan }}</strong></p>
            </div>
            <a href="{{ route('admin.pengajuan-surats.index') }}" class="btn-outline-custom">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        @php
            $statusMap = [
                'menunggu' => ['class' => 'badge-menunggu', 'label' => 'Menunggu'],
                'diproses' => ['class' => 'badge-diproses', 'label' => 'Diproses'],
                'diterima' => ['class' => 'badge-diterima', 'label' => 'Diterima'],
                'ditolak' => ['class' => 'badge-ditolak', 'label' => 'Ditolak'],
                'selesai' => ['class' => 'badge-selesai', 'label' => 'Selesai'],
            ];
            $st = $statusMap[$pengajuanSurat->status] ?? $statusMap['menunggu'];
        @endphp

        {{-- Header Info Card --}}
        <div class="card-custom p-4 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="detail-header-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size: 15px;">
                            {{ $pengajuanSurat->jenisSurat->nama_surat ?? '-' }}
                        </div>
                        <small class="text-muted" style="font-size: 12px;">
                            Diajukan: {{ $pengajuanSurat->created_at?->format('d F Y, H:i') ?? '-' }} WITA
                        </small>
                    </div>
                </div>

                <span class="badge-status badge-lg {{ $st['class'] }}">
                    <span class="dot"></span>
                    {{ $st['label'] }}
                </span>
            </div>
        </div>

        <div class="row g-3">
            {{-- Kolom Kiri --}}
            <div class="col-lg-8">

                {{-- Info Pengajuan --}}
                <div class="card-custom p-4 mb-3">
                    <div class="section-heading">
                        <i class="fa-solid fa-circle-info"></i>
                        <h6 class="fw-bold mb-0">Informasi Pengajuan</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Nomor Pengajuan</div>
                                <div class="detail-value">{{ $pengajuanSurat->nomor_pengajuan }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Jenis Surat</div>
                                <div class="detail-value">{{ $pengajuanSurat->jenisSurat->nama_surat ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Tanggal Pengajuan</div>

                                <div class="detail-value">
                                    {{ $pengajuanSurat->created_at?->format('d F Y, H:i') ?? '-' }} WITA
                                </div>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="badge-status {{ $st['class'] }}">
                                        <span class="dot"></span> {{ $st['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-block">
                                <div class="detail-label">Keperluan</div>
                                <div class="detail-value">{{ $pengajuanSurat->keperluan }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Mahasiswa --}}
                <div class="card-custom p-4 mb-3">
                    <div class="section-heading">
                        <i class="fa-solid fa-user-graduate"></i>
                        <h6 class="fw-bold mb-0">Informasi Mahasiswa</h6>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3 mb-3"
                        style="background: var(--slate-100); border-radius: 12px;">
                        <div class="user-avatar" style="width: 56px; height: 56px; font-size: 20px;">
                            {{ strtoupper(substr($pengajuanSurat->mahasiswa->nama ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size: 15px;">
                                {{ $pengajuanSurat->mahasiswa->nama ?? '-' }}
                            </div>
                            <small class="text-muted" style="font-size: 12px;">
                                {{ $pengajuanSurat->mahasiswa->nim ?? '-' }}
                            </small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Program Studi</div>
                                <div class="detail-value">{{ $pengajuanSurat->mahasiswa->program_studi ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Fakultas</div>
                                <div class="detail-value">{{ $pengajuanSurat->mahasiswa->fakultas ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">Email</div>
                                <div class="detail-value">{{ $pengajuanSurat->mahasiswa->user->email ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-block">
                                <div class="detail-label">No. HP</div>
                                <div class="detail-value">{{ $pengajuanSurat->mahasiswa->no_hp ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dokumen Pendukung --}}
                @if($pengajuanSurat->dokumenPengajuans && $pengajuanSurat->dokumenPengajuans->count() > 0)
                    <div class="card-custom p-4">
                        <div class="section-heading">
                            <i class="fa-solid fa-paperclip"></i>
                            <h6 class="fw-bold mb-0">Dokumen Pendukung</h6>
                        </div>

                        <div class="row g-2">
                            @foreach($pengajuanSurat->dokumenPengajuans as $dok)
                                <div class="col-md-6">
                                    <div class="dokumen-item">
                                        <div class="dokumen-icon">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold text-truncate" style="font-size: 12.5px;">
                                                {{ $dok->nama_dokumen }}
                                            </div>
                                            <small class="text-muted" style="font-size: 11px;">
                                                {{ ucfirst($dok->status ?? '-') }}
                                            </small>
                                        </div>
                                        <a href="{{ Storage::url($dok->file) }}" target="_blank" class="btn-icon-doc" title="Lihat">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>


            {{-- Kolom Kanan --}}
            <div class="col-lg-4">
                <div class="card-custom p-4 sticky-sidebar">
                    <div class="section-heading">
                        <i class="fa-solid fa-shield-halved"></i>
                        <h6 class="fw-bold mb-0">Persetujuan Pengajuan</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Status Saat Ini</label>
                        <div class="detail-value">
                            <span class="badge-status {{ $st['class'] }}">
                                <span class="dot"></span>
                                {{ $st['label'] }}
                            </span>
                        </div>
                    </div>


                    @if(in_array($pengajuanSurat->status, ['menunggu', 'diproses']))
                        <form action="{{ route('admin.pengajuan-surats.update', ['pengajuan_surat' => $pengajuanSurat->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="catatan_admin" class="form-label-custom">
                                    Catatan / Alasan Penolakan
                                </label>

                                <textarea name="catatan_admin" id="catatan_admin" rows="4" class="form-control-custom"
                                    placeholder="Isi alasan jika pengajuan ditolak...">{{ old('catatan_admin', $pengajuanSurat->catatan_admin) }}</textarea>

                                @error('catatan_admin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="status" value="selesai" class="btn btn-success"
                                    onclick="return confirm('Setujui pengajuan ini? Mahasiswa akan dapat mengunduh PDF surat.')">
                                    <i class="fa-solid fa-check"></i>
                                    Setujui Pengajuan
                                </button>

                                <button type="submit" name="status" value="ditolak" class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                    <i class="fa-solid fa-xmark"></i>
                                    Tolak Pengajuan
                                </button>
                            </div>
                        </form>
                    @elseif($pengajuanSurat->status === 'selesai')
                        <div class="alert alert-success">
                            <i class="fa-solid fa-circle-check"></i>
                            Pengajuan telah disetujui. Mahasiswa dapat mengunduh surat.
                        </div>
                    @elseif($pengajuanSurat->status === 'ditolak')
                        <div class="alert alert-danger">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Pengajuan telah ditolak.
                        </div>

                        @if($pengajuanSurat->catatan_admin)
                            <div class="detail-block mt-3">
                                <div class="detail-label">Alasan Penolakan</div>
                                <div class="detail-value">
                                    {{ $pengajuanSurat->catatan_admin }}
                                </div>
                            </div>
                        @endif
                    @endif


                    @if($pengajuanSurat->file_surat)
                        <hr>

                        <div class="mb-2">
                            <label class="form-label-custom">PDF Surat</label>
                            <p class="text-muted small">
                                PDF telah dibuat dan disimpan.
                                @if($pengajuanSurat->status !== 'selesai')
                                    Mahasiswa belum dapat mengunduhnya sebelum disetujui.
                                @endif
                            </p>

                            <a href="{{ Storage::url($pengajuanSurat->file_surat) }}" target="_blank"
                                class="btn-outline-custom w-100 justify-content-center">
                                <i class="fa-solid fa-file-pdf"></i>
                                Lihat PDF
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning small">
                            File PDF surat belum tersedia.
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

@endsection

@section('styles')
    <style>
        .breadcrumb-inline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--slate-500);
        }

        .breadcrumb-inline a {
            color: var(--slate-500);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .breadcrumb-inline a:hover {
            color: var(--primary);
        }

        .breadcrumb-inline i {
            font-size: 9px;
            color: var(--slate-400);
        }

        .breadcrumb-inline span {
            color: var(--primary);
            font-weight: 700;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 14px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--slate-200);
        }

        .section-heading i {
            color: var(--primary);
            font-size: 16px;
        }

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

        .detail-block {
            padding: 4px 0;
        }

        .detail-label {
            font-size: 11px;
            color: var(--slate-500);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 13.5px;
            color: var(--dark);
            font-weight: 600;
            line-height: 1.5;
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

        .badge-lg {
            padding: 8px 16px;
            font-size: 12.5px;
            gap: 6px;
        }

        .badge-lg .dot {
            width: 7px;
            height: 7px;
        }

        .badge-menunggu {
            background: #FEF3C7;
            color: #B45309;
        }

        .badge-diproses {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .badge-diterima {
            background: #E0E7FF;
            color: #4338CA;
        }

        .badge-ditolak {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .badge-selesai {
            background: #D1FAE5;
            color: #047857;
        }

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
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-icon-doc:hover {
            background: var(--primary);
            color: white;
        }

        .sticky-sidebar {
            position: sticky;
            top: 90px;
        }

        .form-label-custom {
            display: block;
            font-weight: 700;
            font-size: 12.5px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .form-control-custom,
        .form-select-custom {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--slate-200);
            border-radius: 10px;
            font-family: inherit;
            font-size: 13.5px;
            color: var(--dark);
            background: white;
            outline: none;
            transition: all 0.2s;
        }

        textarea.form-control-custom {
            resize: vertical;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(201, 180, 88, 0.15);
        }

        .form-hint {
            display: block;
            font-size: 11.5px;
            color: var(--slate-500);
            margin-top: 6px;
        }

        .file-existing {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            background: var(--primary-light);
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .alert-custom {
            border-radius: 10px;
            padding: 14px 18px;
            border: 1px solid;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-custom.success {
            background: #ECFDF5;
            border-color: #A7F3D0;
            color: #047857;
        }

        .alert-custom.error {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #B91C1C;
        }
    </style>
@endsection