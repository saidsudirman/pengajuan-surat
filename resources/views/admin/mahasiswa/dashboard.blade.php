@extends('layouts.admin')

@section('title', 'Dashboard Mahasiswa')

@section('content')

<div class="container-fluid">

    <h3 class="fw-bold">
        Dashboard Mahasiswa
    </h3>

    <p class="text-muted">
        Selamat datang, {{ auth()->user()->name }}
    </p>

    <div class="card">
        <div class="card-body">
            <h5>Pengajuan Surat Akademik</h5>

            <p>
                Silakan gunakan sistem untuk melakukan pengajuan
                surat akademik.
            </p>
        </div>
    </div>

</div>

@endsection