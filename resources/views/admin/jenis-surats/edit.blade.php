@extends('layouts.admin')

@section('title', 'Edit Jenis Surat')
@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Edit Jenis Surat</h3>
        <p class="text-muted mb-0">
            Perbarui data jenis surat.
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form
                action="{{ route('admin.jenis-surats.update', $jenisSurat) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Nama Surat
                    </label>

                    <input
                        type="text"
                        name="nama_surat"
                        value="{{ old('nama_surat', $jenisSurat->nama_surat) }}"
                        class="form-control @error('nama_surat') is-invalid @enderror"
                        required
                    >

                    @error('nama_surat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        rows="4"
                        class="form-control @error('deskripsi') is-invalid @enderror"
                    >{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Template Surat
                    </label>

                    <input
                        type="text"
                        name="template_surat"
                        value="{{ old('template_surat', $jenisSurat->template_surat) }}"
                        class="form-control @error('template_surat') is-invalid @enderror"
                    >

                    @error('template_surat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                    >

                        <option value="aktif"
                            @selected(old('status', $jenisSurat->status) === 'aktif')>
                            Aktif
                        </option>

                        <option value="tidak_aktif"
                            @selected(old('status', $jenisSurat->status) === 'tidak_aktif')>
                            Tidak Aktif
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <a href="{{ route('admin.jenis-surats.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit"
                        class="btn btn-primary">
                    Simpan Perubahan
                </button>

            </form>

        </div>

    </div>

</div>
@endsection