@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')

    <div class="container-fluid p-0">

        {{-- Page Header --}}
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1>Data Mahasiswa</h1>
                <p>Kelola data mahasiswa dan akun login mereka.</p>
            </div>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn-primary-custom">
                <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
            </a>
        </div>

        {{-- Filter --}}
        <form action="{{ route('admin.mahasiswa.index') }}" method="GET" id="filterForm">
            <div class="card-custom p-4 mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 12.5px; color: var(--slate-500);">
                            Cari Mahasiswa
                        </label>
                        <div class="search-wrapper" style="flex: none;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Nama, NIM, atau Email..." autocomplete="off">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label fw-semibold" style="font-size: 12.5px; color: var(--slate-500);">
                            Program Studi
                        </label>
                        <select name="program_studi" id="prodiSelect" class="form-select"
                            style="border-radius: 10px; font-size: 13px; border-color: var(--slate-200);">
                            <option value="">Semua Prodi</option>
                            @foreach($programStudis as $prodi)
                                <option value="{{ $prodi }}" {{ request('program_studi') === $prodi ? 'selected' : '' }}>
                                    {{ $prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-12 d-flex gap-2">
                        <button type="submit" class="btn-primary-custom flex-grow-1 justify-content-center">
                            <i class="fa-solid fa-filter"></i> Terapkan
                        </button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn-outline-custom" title="Reset Filter"
                            id="resetBtn">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>

                {{-- Info filter aktif --}}
                @if(request('search') || request('program_studi'))
                    <div class="active-filters mt-3">
                        <span class="filter-label">Filter aktif:</span>

                        @if(request('search'))
                            <span class="filter-tag">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                "{{ request('search') }}"
                                <a href="{{ route('admin.mahasiswa.index', array_filter(['program_studi' => request('program_studi')])) }}"
                                    class="filter-remove">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </span>
                        @endif

                        @if(request('program_studi'))
                            <span class="filter-tag">
                                <i class="fa-solid fa-book"></i>
                                {{ request('program_studi') }}
                                <a href="{{ route('admin.mahasiswa.index', array_filter(['search' => request('search')])) }}"
                                    class="filter-remove">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="card-custom">
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th style="width: 180px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mahasiswas as $mahasiswa)
                            <tr>
                                <td>
                                    <span class="fw-semibold text-muted">
                                        {{ $loop->iteration + ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar" style="width: 42px; height: 42px; font-size: 15px;">
                                            {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="color: var(--dark);">
                                                {{ $mahasiswa->nama }}
                                            </div>
                                            <small class="text-muted" style="font-size: 11.5px;">
                                                {{ $mahasiswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($mahasiswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge-nim">
                                        <i class="fa-solid fa-id-card"></i>
                                        {{ $mahasiswa->nim }}
                                    </span>
                                </td>

                                <td>
                                    <span class="text-muted" style="font-size: 13px;">
                                        {{ $mahasiswa->user->email ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="fw-semibold" style="font-size: 13px;">
                                        {{ $mahasiswa->program_studi }}
                                    </span>
                                </td>

                                <td>
                                    @if($mahasiswa->angkatan)
                                        <span class="badge-angkatan">{{ $mahasiswa->angkatan }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}"
                                            class="btn-action btn-action-view" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}"
                                            class="btn-action btn-action-edit" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
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
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fa-solid fa-users"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Belum Ada Data Mahasiswa</h6>
                                        <p class="text-muted mb-3" style="font-size: 13px;">
                                            Mulai dengan menambahkan data mahasiswa baru.
                                        </p>
                                        <a href="{{ route('admin.mahasiswa.create') }}" class="btn-primary-custom">
                                            <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mahasiswas->hasPages())
                <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2"
                    style="border-color: var(--slate-200) !important;">
                    <small class="text-muted">
                        Menampilkan {{ $mahasiswas->firstItem() }}–{{ $mahasiswas->lastItem() }}
                        dari {{ $mahasiswas->total() }} mahasiswa
                    </small>
                    {{ $mahasiswas->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection

@section('styles')
    <style>
        .badge-nim {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }

        .badge-nim i {
            font-size: 11px;
        }

        .badge-angkatan {
            display: inline-block;
            background: var(--slate-100);
            color: var(--slate-700);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
        }

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

        .btn-action-view {
            color: #2563EB;
        }

        .btn-action-view:hover {
            background: #DBEAFE;
            border-color: #93C5FD;
            color: #1D4ED8;
            transform: translateY(-1px);
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
            color: var(--primary-dark);
        }

        .btn-action-delete:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

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

        .pagination .page-item.disabled .page-link {
            color: var(--slate-400);
            background: var(--slate-100);
        }
    </style>
@endsection