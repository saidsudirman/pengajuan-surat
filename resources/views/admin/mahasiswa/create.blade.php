@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')

<div class="container-fluid p-0">

    {{-- Page Header --}}
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="breadcrumb-inline mb-2">
                <a href="{{ route('admin.mahasiswa.index') }}">Data Mahasiswa</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Tambah</span>
            </div>
            <h1>Tambah Mahasiswa</h1>
            <p>Tambahkan data mahasiswa sekaligus akun login mereka.</p>
        </div>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn-outline-custom">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.mahasiswa.store') }}" method="POST" id="formMahasiswa">
        @csrf

        <div class="row g-3">

            {{-- Data Akademik --}}
            <div class="col-lg-8">
                <div class="card-custom p-4 mb-3">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Data Akademik</h6>
                            <small class="text-muted" style="font-size: 12.5px;">
                                Informasi akademik mahasiswa
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">NIM <span class="text-danger">*</span></label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-id-card input-icon"></i>
                                <input type="text"
                                       name="nim"
                                       value="{{ old('nim') }}"
                                       class="form-control-custom @error('nim') is-invalid @enderror"
                                       placeholder="Contoh: 242021"
                                       required>
                            </div>
                            @error('nim')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-user input-icon"></i>
                                <input type="text"
                                       name="nama"
                                       value="{{ old('nama') }}"
                                       class="form-control-custom @error('nama') is-invalid @enderror"
                                       placeholder="Nama lengkap mahasiswa"
                                       required>
                            </div>
                            @error('nama')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Tempat Lahir</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-location-dot input-icon"></i>
                                <input type="text"
                                       name="tempat_lahir"
                                       value="{{ old('tempat_lahir') }}"
                                       class="form-control-custom"
                                       placeholder="Kota kelahiran">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Tanggal Lahir</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-calendar input-icon"></i>
                                <input type="date"
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir') }}"
                                       class="form-control-custom">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin"
                                    class="form-control-custom @error('jenis_kelamin') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">No. HP</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-phone input-icon"></i>
                                <input type="text"
                                       name="no_hp"
                                       value="{{ old('no_hp') }}"
                                       class="form-control-custom"
                                       placeholder="08xx-xxxx-xxxx">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Fakultas</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-building-columns input-icon"></i>
                                <input type="text"
                                       name="fakultas"
                                       value="{{ old('fakultas') }}"
                                       class="form-control-custom"
                                       placeholder="Contoh: Teknik">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Program Studi <span class="text-danger">*</span></label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-book input-icon"></i>
                                <input type="text"
                                       name="program_studi"
                                       value="{{ old('program_studi') }}"
                                       class="form-control-custom @error('program_studi') is-invalid @enderror"
                                       placeholder="Contoh: Teknik Informatika"
                                       required>
                            </div>
                            @error('program_studi')
                                <div class="invalid-feedback-custom">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label-custom">Angkatan</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-calendar-check input-icon"></i>
                                <input type="text"
                                       name="angkatan"
                                       value="{{ old('angkatan') }}"
                                       class="form-control-custom"
                                       placeholder="2024">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label-custom">Semester</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-layer-group input-icon"></i>
                                <input type="text"
                                       name="semester"
                                       value="{{ old('semester') }}"
                                       class="form-control-custom"
                                       placeholder="1">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label-custom">Tahun Akademik</label>
                            <div class="input-icon-wrapper">
                                <i class="fa-solid fa-calendar-days input-icon"></i>
                                <input type="text"
                                       name="tahun_akademik"
                                       value="{{ old('tahun_akademik') }}"
                                       class="form-control-custom"
                                       placeholder="2026/2027">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label-custom">Alamat</label>
                            <textarea name="alamat"
                                      class="form-control-custom"
                                      rows="3"
                                      placeholder="Alamat lengkap mahasiswa..."
                                      style="padding-left: 16px; resize: vertical;">{{ old('alamat') }}</textarea>
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

                    <div class="mb-3">
                        <label class="form-label-custom">Email <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control-custom @error('email') is-invalid @enderror"
                                   placeholder="nama@mahasiswa.ac.id"
                                   required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Password <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-key input-icon"></i>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control-custom @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 karakter"
                                   required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Konfirmasi Password <span class="text-danger">*</span></label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-key input-icon"></i>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control-custom"
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>

                    <div class="info-box">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Akun ini akan digunakan mahasiswa untuk login ke sistem pengajuan surat.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-end gap-2 mt-2">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-outline-custom">
                <i class="fa-solid fa-xmark"></i> Batal
            </a>
            <button type="submit" class="btn-primary-custom">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Mahasiswa
            </button>
        </div>
    </form>

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

    .form-label-custom {
        display: block;
        font-weight: 700;
        font-size: 12.5px;
        color: var(--dark);
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--slate-200);
        border-radius: 12px;
        font-family: inherit;
        font-size: 13.5px;
        color: var(--dark);
        background: #F8FAFC;
        transition: var(--transition);
        outline: none;
    }

    .form-control-custom::placeholder { color: #B0B7C3; }

    .form-control-custom:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(201, 180, 88, 0.15);
    }

    .form-control-custom.is-invalid {
        border-color: #DC2626;
        background: #FEF2F2;
    }

    .input-icon-wrapper { position: relative; }

    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--slate-400);
        font-size: 13.5px;
        pointer-events: none;
        transition: var(--transition);
    }

    .input-icon-wrapper .form-control-custom { padding-left: 44px; }

    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--slate-400);
        cursor: pointer;
        font-size: 14px;
        padding: 4px;
        transition: var(--transition);
    }

    .toggle-password:hover { color: var(--primary); }

    .invalid-feedback-custom {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 12px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        line-height: 1.5;
        border-left: 3px solid var(--primary);
    }

    .info-box i { margin-top: 2px; flex-shrink: 0; }
</style>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection