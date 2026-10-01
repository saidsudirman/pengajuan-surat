@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')

<div class="container-fluid p-0">

    {{-- Page Header --}}
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="breadcrumb-inline mb-2">
                <a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Detail</span>
            </div>
            <h1>Detail Mahasiswa</h1>
            <p>Informasi lengkap mahasiswa.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="btn-primary-custom">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-outline-custom">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="card-custom p-4 mb-4">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <div class="profile-avatar">
                {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <h3 class="fw-bold mb-1" style="font-size: 22px;">{{ $mahasiswa->nama }}</h3>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span class="badge-nim">
                        <i class="fa-solid fa-id-card"></i> {{ $mahasiswa->nim }}
                    </span>
                    <span class="badge-angkatan">Angkatan {{ $mahasiswa->angkatan ?? '-' }}</span>
                    <span class="badge-prodi">
                        <i class="fa-solid fa-book"></i> {{ $mahasiswa->program_studi }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Data Akademik --}}
        <div class="col-lg-8">
            <div class="card-custom p-4">
                <div class="form-section-header">
                    <div class="form-section-icon">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Data Akademik</h6>
                        <small class="text-muted" style="font-size: 12.5px;">
                            Informasi akademik lengkap mahasiswa
                        </small>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-id-card"></i> NIM
                            </div>
                            <div class="detail-value">{{ $mahasiswa->nim }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-user"></i> Nama Lengkap
                            </div>
                            <div class="detail-value">{{ $mahasiswa->nama }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-location-dot"></i> Tempat, Tanggal Lahir
                            </div>
                            <div class="detail-value">
                                {{ $mahasiswa->tempat_lahir ?? '-' }}@if($mahasiswa->tanggal_lahir), {{ $mahasiswa->tanggal_lahir->format('d F Y') }}@endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-venus-mars"></i> Jenis Kelamin
                            </div>
                            <div class="detail-value">
                                @if($mahasiswa->jenis_kelamin === 'L')
                                    Laki-laki
                                @elseif($mahasiswa->jenis_kelamin === 'P')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-building-columns"></i> Fakultas
                            </div>
                            <div class="detail-value">{{ $mahasiswa->fakultas ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-book"></i> Program Studi
                            </div>
                            <div class="detail-value">{{ $mahasiswa->program_studi }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-calendar-check"></i> Angkatan
                            </div>
                            <div class="detail-value">{{ $mahasiswa->angkatan ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-layer-group"></i> Semester
                            </div>
                            <div class="detail-value">{{ $mahasiswa->semester ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-calendar-days"></i> Tahun Akademik
                            </div>
                            <div class="detail-value">{{ $mahasiswa->tahun_akademik ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fa-solid fa-location-dot"></i> Alamat
                            </div>
                            <div class="detail-value">{{ $mahasiswa->alamat ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Akun Login --}}
        <div class="col-lg-4">
            <div class="card-custom p-4 mb-3">
                <div class="form-section-header">
                    <div class="form-section-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Akun Login</h6>
                        <small class="text-muted" style="font-size: 12.5px;">
                            Kredensial mahasiswa
                        </small>
                    </div>
                </div>

                <div class="account-item">
                    <div class="account-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="account-content">
                        <div class="account-label">Nama</div>
                        <div class="account-value">{{ $mahasiswa->user->name ?? '-' }}</div>
                    </div>
                </div>

                <div class="account-item">
                    <div class="account-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="account-content">
                        <div class="account-label">Email</div>
                        <div class="account-value">{{ $mahasiswa->user->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="account-item">
                    <div class="account-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="account-content">
                        <div class="account-label">No. HP</div>
                        <div class="account-value">{{ $mahasiswa->no_hp ?? '-' }}</div>
                    </div>
                </div>

                <div class="account-item">
                    <div class="account-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="account-content">
                        <div class="account-label">Role</div>
                        <div class="account-value">
                            <span class="badge-role">
                                <i class="fa-solid fa-graduation-cap"></i> Mahasiswa
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="card-custom p-4" style="border-color: #FECACA;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon red" style="width: 42px; height: 42px; font-size: 16px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size: 14px; color: #B91C1C;">Zona Berbahaya</h6>
                        <small class="text-muted" style="font-size: 11.5px;">Tindakan permanen</small>
                    </div>
                </div>
                <p class="text-muted mb-3" style="font-size: 12.5px; line-height: 1.5;">
                    Menghapus mahasiswa akan menghilangkan data dan akun login secara permanen.
                </p>
                <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-custom w-100">
                        <i class="fa-solid fa-trash"></i> Hapus Mahasiswa
                    </button>
                </form>
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

    .breadcrumb-inline a:hover { color: var(--primary); }
    .breadcrumb-inline i { font-size: 9px; color: var(--slate-400); }
    .breadcrumb-inline span { color: var(--primary); font-weight: 700; }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
        box-shadow: 0 8px 20px -4px rgba(201, 180, 88, 0.45);
        flex-shrink: 0;
    }

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

    .badge-angkatan {
        display: inline-block;
        background: var(--slate-100);
        color: var(--slate-700);
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-prodi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #DBEAFE;
        color: #1D4ED8;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .form-section-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 20px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--slate-200);
    }

    .form-section-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .detail-item {
        padding: 4px 0;
    }

    .detail-label {
        font-size: 11.5px;
        color: var(--slate-500);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-label i {
        color: var(--primary);
        font-size: 11px;
    }

    .detail-value {
        font-size: 14px;
        color: var(--dark);
        font-weight: 600;
        line-height: 1.5;
    }

    .account-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--slate-100);
    }

    .account-item:last-child { border-bottom: none; }

    .account-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--slate-100);
        color: var(--slate-500);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .account-content { flex: 1; min-width: 0; }

    .account-label {
        font-size: 11px;
        color: var(--slate-500);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }

    .account-value {
        font-size: 13px;
        color: var(--dark);
        font-weight: 600;
        word-break: break-word;
    }

    .badge-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #D1FAE5;
        color: #047857;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
    }

    .btn-danger-custom {
        background: #DC2626;
        color: white;
        border: none;
        padding: 11px 18px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-danger-custom:hover {
        background: #B91C1C;
        transform: translateY(-1px);
        box-shadow: 0 8px 18px -4px rgba(220, 38, 38, 0.4);
    }
</style>
@endsection