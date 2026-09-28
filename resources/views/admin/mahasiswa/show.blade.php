@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            Detail Mahasiswa
        </h3>

        <p class="text-muted mb-0">
            Informasi lengkap mahasiswa
        </p>

    </div>

    <div>

        <a
            href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}"
            class="btn btn-warning"
        >
            <i class="fa-solid fa-pen me-1"></i>
            Edit
        </a>

        <a
            href="{{ route('admin.mahasiswa.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>

</div>


<div class="row g-4">

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5 class="fw-bold mb-4">
                    Data Akademik
                </h5>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        NIM
                    </div>

                    <div class="col-md-8 fw-semibold">
                        {{ $mahasiswa->nim }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Nama Lengkap
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->nama }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Tempat, Tanggal Lahir
                    </div>

                    <div class="col-md-8">

                        {{ $mahasiswa->tempat_lahir ?? '-' }},

                        @if($mahasiswa->tanggal_lahir)
                            {{ $mahasiswa->tanggal_lahir->format('d F Y') }}
                        @else
                            -
                        @endif

                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Jenis Kelamin
                    </div>

                    <div class="col-md-8">

                        @if($mahasiswa->jenis_kelamin === 'L')
                            Laki-laki
                        @elseif($mahasiswa->jenis_kelamin === 'P')
                            Perempuan
                        @else
                            -
                        @endif

                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Fakultas
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->fakultas ?? '-' }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Program Studi
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->program_studi }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Angkatan
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->angkatan ?? '-' }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Semester
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->semester ?? '-' }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        Tahun Akademik
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->tahun_akademik ?? '-' }}
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 text-muted">
                        Alamat
                    </div>

                    <div class="col-md-8">
                        {{ $mahasiswa->alamat ?? '-' }}
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

                    <small class="text-muted">
                        Nama
                    </small>

                    <div class="fw-semibold">
                        {{ $mahasiswa->user->name ?? '-' }}
                    </div>

                </div>

                <div class="mb-3">

                    <small class="text-muted">
                        Email
                    </small>

                    <div>
                        {{ $mahasiswa->user->email ?? '-' }}
                    </div>

                </div>

                <div class="mb-3">

                    <small class="text-muted">
                        Role
                    </small>

                    <div>
                        <span class="badge bg-success">
                            Mahasiswa
                        </span>
                    </div>

                </div>

                <div>

                    <small class="text-muted">
                        No. HP
                    </small>

                    <div>
                        {{ $mahasiswa->no_hp ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection