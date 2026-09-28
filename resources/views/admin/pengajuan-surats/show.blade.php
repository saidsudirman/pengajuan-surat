@extends('layouts.admin')

@section('title', 'Detail Pengajuan Surat')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Pengajuan Surat</h3>
        <p class="text-muted mb-0">
            Informasi dan proses pengajuan surat mahasiswa
        </p>
    </div>

    <a href="{{ route('admin.pengajuan-surats.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row">

    <div class="col-md-8">

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Pengajuan</h5>
            </div>

            <div class="card-body">

                <table class="table">

                    <tr>
                        <th width="220">Nomor Pengajuan</th>
                        <td>
                            {{ $pengajuanSurat->nomor_pengajuan }}
                        </td>
                    </tr>

                    <tr>
                        <th>Nama Mahasiswa</th>
                        <td>
                            {{ $pengajuanSurat->mahasiswa->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>NIM</th>
                        <td>
                            {{ $pengajuanSurat->mahasiswa->nim ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Program Studi</th>
                        <td>
                            {{ $pengajuanSurat->mahasiswa->program_studi ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Jenis Surat</th>
                        <td>
                            {{ $pengajuanSurat->jenisSurat->nama_surat ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Keperluan</th>
                        <td>
                            {{ $pengajuanSurat->keperluan }}
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>
                            {{ $pengajuanSurat->created_at->format('d F Y H:i') }}
                        </td>
                    </tr>

                </table>

            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Proses Pengajuan</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.pengajuan-surats.update', $pengajuanSurat) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status" class="form-select">

                            <option value="menunggu"
                                {{ $pengajuanSurat->status === 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="diproses"
                                {{ $pengajuanSurat->status === 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="diterima"
                                {{ $pengajuanSurat->status === 'diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>

                            <option value="ditolak"
                                {{ $pengajuanSurat->status === 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                            <option value="selesai"
                                {{ $pengajuanSurat->status === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Catatan Admin
                        </label>

                        <textarea name="catatan_admin"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Masukkan catatan...">{{ old('catatan_admin', $pengajuanSurat->catatan_admin) }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            File Surat
                        </label>

                        <input type="file"
                               name="file_surat"
                               class="form-control">

                        <small class="text-muted">
                            Format PDF, maksimal 5 MB.
                        </small>

                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">
                        Simpan Perubahan
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection