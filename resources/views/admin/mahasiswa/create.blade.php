@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-1">Tambah Mahasiswa</h3>
    <p class="text-muted mb-0">
        Tambahkan data mahasiswa sekaligus akun login
    </p>
</div>

<form
    action="{{ route('admin.mahasiswa.store') }}"
    method="POST"
>

    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Data Akademik
                    </h5>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                NIM
                            </label>

                            <input
                                type="text"
                                name="nim"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim') }}"
                                required
                            >

                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}"
                                required
                            >

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                name="tempat_lahir"
                                class="form-control"
                                value="{{ old('tempat_lahir') }}"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tanggal Lahir
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir"
                                class="form-control"
                                value="{{ old('tanggal_lahir') }}"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih Jenis Kelamin
                                </option>

                                <option
                                    value="L"
                                    @selected(old('jenis_kelamin') === 'L')
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="P"
                                    @selected(old('jenis_kelamin') === 'P')
                                >
                                    Perempuan
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                No. HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="{{ old('no_hp') }}"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Fakultas
                            </label>

                            <input
                                type="text"
                                name="fakultas"
                                class="form-control"
                                value="{{ old('fakultas') }}"
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Program Studi
                            </label>

                            <input
                                type="text"
                                name="program_studi"
                                class="form-control"
                                value="{{ old('program_studi') }}"
                                required
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Angkatan
                            </label>

                            <input
                                type="text"
                                name="angkatan"
                                class="form-control"
                                value="{{ old('angkatan') }}"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Semester
                            </label>

                            <input
                                type="text"
                                name="semester"
                                class="form-control"
                                value="{{ old('semester') }}"
                            >

                        </div>

                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Tahun Akademik
                            </label>

                            <input
                                type="text"
                                name="tahun_akademik"
                                class="form-control"
                                value="{{ old('tahun_akademik') }}"
                                placeholder="2026/2027"
                            >

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3"
                            >{{ old('alamat') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Akun Login
                    </h5>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="alert alert-info small">
                        Akun ini akan digunakan mahasiswa untuk login ke sistem.
                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="mt-4">

        <a
            href="{{ route('admin.mahasiswa.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-save me-1"></i>
            Simpan Mahasiswa
        </button>

    </div>

</form>

@endsection