@extends('layouts.admin')

@section('title', 'Jenis Surat')

@section('content')

    <div class="container-fluid p-0">

        {{-- Page Header --}}
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1>Jenis Surat</h1>
                <p>Kelola jenis surat akademik yang tersedia untuk mahasiswa.</p>
            </div>
            <a href="{{ route('admin.jenis-surats.create') }}" class="btn-primary-custom">
                <i class="fa-solid fa-plus"></i> Tambah Jenis Surat
            </a>
        </div>

        {{-- Filter & Search --}}
        <form action="{{ route('admin.jenis-surats.index') }}" method="GET" id="filterForm">
            <div class="card-custom p-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 12.5px; color: var(--slate-500);">
                            Cari Jenis Surat
                        </label>
                        <div class="search-wrapper" style="flex: none;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama atau deskripsi jenis surat...">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 12.5px; color: var(--slate-500);">
                            Status
                        </label>
                        <select name="status" class="form-select"
                            style="border-radius: 10px; font-size: 13px; border-color: var(--slate-200);">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak
                                Aktif</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn-primary-custom flex-grow-1 justify-content-center">
                            <i class="fa-solid fa-filter"></i> Terapkan
                        </button>
                        <a href="{{ route('admin.jenis-surats.index') }}" class="btn-outline-custom" title="Reset Filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        {{-- Table Card --}}
        <div class="card-custom">
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Surat</th>
                            <th>Deskripsi</th>
                            <th>Template</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 160px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($jenisSurats as $jenisSurat)
                            <tr>
                                <td>
                                    <span class="fw-semibold text-muted">
                                        {{ $jenisSurats->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon red" style="width: 40px; height: 40px; font-size: 15px;">
                                            <i class="fa-solid fa-file-lines"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: var(--dark);">
                                                {{ $jenisSurat->nama_surat }}
                                            </div>
                                            <small class="text-muted" style="font-size: 11.5px;">
                                                Dibuat: {{ $jenisSurat->created_at?->format('d M Y') ?? '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted" style="font-size: 13px;">
                                        {{ Str::limit($jenisSurat->deskripsi ?? '-', 60) }}
                                    </span>
                                </td>

                                <td>
                                    @if($jenisSurat->template_surat)
                                        <span class="badge-file">
                                            <i class="fa-solid fa-file-word"></i>
                                            {{ Str::limit($jenisSurat->template_surat, 25) }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 12.5px;">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($jenisSurat->status === 'aktif')
                                        <span class="badge-status badge-selesai">
                                            <span class="dot"></span> Aktif
                                        </span>
                                    @else
                                        <span class="badge-status badge-ditolak" style="background: #F1F5F9; color: #64748B;">
                                            <span class="dot"></span> Tidak Aktif
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.jenis-surats.edit', $jenisSurat) }}"
                                            class="btn-action btn-action-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.jenis-surats.destroy', $jenisSurat) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fa-regular fa-folder-open"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Belum Ada Jenis Surat</h6>
                                        <p class="text-muted mb-3" style="font-size: 13px;">
                                            Mulai dengan menambahkan jenis surat akademik baru.
                                        </p>
                                        <a href="{{ route('admin.jenis-surats.create') }}" class="btn-primary-custom">
                                            <i class="fa-solid fa-plus"></i> Tambah Jenis Surat
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($jenisSurats->hasPages())
                <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2"
                    style="border-color: var(--slate-200) !important;">
                    <small class="text-muted">
                        Menampilkan {{ $jenisSurats->firstItem() }}–{{ $jenisSurats->lastItem() }}
                        dari {{ $jenisSurats->total() }} jenis surat
                    </small>
                    {{ $jenisSurats->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection

@section('styles')
    <style>
        /* Badge File */
        .badge-file {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #EFF6FF;
            color: #1D4ED8;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-file i {
            font-size: 11px;
        }

        /* Action Buttons */
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

        .btn-action-edit {
            color: #D97706;
        }

        .btn-action-edit:hover {
            background: #FEF3C7;
            border-color: #FCD34D;
            color: #B45309;
            transform: translateY(-1px);
        }

        .btn-action-delete {
            color: #DC2626;
        }

        .btn-action-delete:hover {
            background: #FEE2E2;
            border-color: #FCA5A5;
            color: #B91C1C;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 20px;
            background: var(--slate-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--slate-400);
        }

        /* Pagination customization */
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
            color: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: var(--slate-400);
            background: var(--slate-100);
        }
    </style>
@endsection