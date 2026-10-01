@extends('layouts.mahasiswa')

@section('title', 'Profil Saya')
@section('subtitle', 'Kelola data pribadi Anda')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header-mhs mb-4">
        <h1>Profil Saya</h1>
        <p>Kelola data pribadi dan keamanan akun Anda.</p>
    </div>


    <div class="row g-3">

        <div class="col-lg-4">
            <div class="card-mhs p-3 p-md-4 mb-3 text-center">
                <div style="width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 800; margin: 0 auto 16px; box-shadow: 0 8px 20px rgba(201, 180, 88, 0.4);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-3" style="font-size: 12.5px;">
                    {{ $mahasiswa->nim ?? '-' }}
                </p>

                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <span style="display: inline-flex; align-items: center; gap: 5px; background: var(--primary-light); color: var(--primary-dark); padding: 5px 12px; border-radius: 50px; font-size: 11.5px; font-weight: 700;">
                        <i class="fa-solid fa-graduation-cap"></i> Mahasiswa
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 5px; background: var(--slate-100); color: var(--slate-700); padding: 5px 12px; border-radius: 50px; font-size: 11.5px; font-weight: 700;">
                        {{ $mahasiswa->angkatan ?? '-' }}
                    </span>
                </div>
            </div>

            <div class="card-mhs p-3 p-md-4">
                <h6 class="fw-bold mb-3" style="font-size: 13.5px;">Data Akademik</h6>

                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--slate-200);">
                    <small class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Program Studi</small>
                    <div class="fw-bold" style="font-size: 13px;">{{ $mahasiswa->program_studi ?? '-' }}</div>
                </div>

                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--slate-200);">
                    <small class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Fakultas</small>
                    <div class="fw-bold" style="font-size: 13px;">{{ $mahasiswa->fakultas ?? '-' }}</div>
                </div>

                <div class="mb-3 pb-3" style="border-bottom: 1px solid var(--slate-200);">
                    <small class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Semester</small>
                    <div class="fw-bold" style="font-size: 13px;">{{ $mahasiswa->semester ?? '-' }}</div>
                </div>

                <div class="mb-0">
                    <small class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase;">Tahun Akademik</small>
                    <div class="fw-bold" style="font-size: 13px;">{{ $mahasiswa->tahun_akademik ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-mhs p-3 p-md-4 mb-3">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-user-pen" style="color: var(--primary);"></i>
                    Data Pribadi
                </h6>

                <form action="{{ route('mahasiswa.profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                            @error('nama')<div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                            @error('email')<div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir) }}"
                                   class="form-control" style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', optional($mahasiswa->tanggal_lahir)->format('Y-m-d')) }}"
                                   class="form-control" style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                                <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                   class="form-control" style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Alamat</label>
                            <textarea name="alamat" rows="3" class="form-control"
                                      style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px; resize: vertical;">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn-mhs-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-mhs p-3 p-md-4">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-lock" style="color: var(--primary);"></i>
                    Ganti Password
                </h6>

                <form action="{{ route('mahasiswa.profil.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" name="password_lama" class="form-control"
                                   style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                            @error('password_lama')<div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control"
                                   style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                            @error('password')<div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 12.5px;">Konfirmasi <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   style="border-radius: 10px; font-size: 13.5px; padding: 11px 14px;" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn-mhs-primary">
                            <i class="fa-solid fa-key"></i> Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection