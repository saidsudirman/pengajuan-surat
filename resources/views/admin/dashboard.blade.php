@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Dashboard Admin</h3>
        <p class="text-muted mb-0">
            Selamat datang, {{ auth()->user()->name }}
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-2">Jenis Surat</p>
                    <h3 class="fw-bold">0</h3>
                    <a href="{{ route('admin.jenis-surats.index') }}"
                       class="text-decoration-none">
                        Kelola Jenis Surat →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-2">Mahasiswa</p>
                    <h3 class="fw-bold">0</h3>
                    <a href="#" class="text-decoration-none">
                        Kelola Mahasiswa →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-2">Pengajuan</p>
                    <h3 class="fw-bold">0</h3>
                    <a href="#" class="text-decoration-none">
                        Lihat Pengajuan →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted mb-2">Menunggu</p>
                    <h3 class="fw-bold">0</h3>
                    <a href="#" class="text-decoration-none">
                        Lihat Pengajuan →
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Sistem Informasi Pengajuan Surat Akademik
            </h5>

            <p class="text-muted mb-0">
                Gunakan menu di sebelah kiri untuk mengelola jenis surat,
                data mahasiswa, dan pengajuan surat akademik.
            </p>

        </div>
    </div>

</div>

@endsection