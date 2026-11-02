
@extends('layouts.admin')

@section('title', 'Pengaturan Surat')

@section('content')
<div class="container-fluid p-0">
    <div class="page-header mb-4">
        <h1>Pengaturan Surat</h1>
        <p>Kelola identitas kampus dan informasi penandatangan surat akademik.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pengaturan-surat.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-custom p-4 mb-3">
            <div class="section-heading">
                <i class="fa-solid fa-building-columns"></i>
                <h6 class="fw-bold mb-0">Identitas Kampus</h6>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Nama Yayasan</label>
                    <input type="text" name="nama_yayasan" class="form-control-custom"
                        value="{{ old('nama_yayasan', $pengaturan->nama_yayasan) }}"
                        placeholder="Yayasan Dipanegara">
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Nama Universitas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_universitas" class="form-control-custom"
                        value="{{ old('nama_universitas', $pengaturan->nama_universitas) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Nama Unit</label>
                    <input type="text" name="nama_unit" class="form-control-custom"
                        value="{{ old('nama_unit', $pengaturan->nama_unit) }}"
                        placeholder="Contoh: Biro Administrasi Akademik">
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Nomor Telepon</label>
                    <input type="text" name="telepon" class="form-control-custom"
                        value="{{ old('telepon', $pengaturan->telepon) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label-custom">Alamat Kampus</label>
                    <textarea name="alamat" rows="2" class="form-control-custom">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Email Resmi</label>
                    <input type="email" name="email" class="form-control-custom"
                        value="{{ old('email', $pengaturan->email) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Website</label>
                    <input type="text" name="website" class="form-control-custom"
                        value="{{ old('website', $pengaturan->website) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label-custom">Logo Universitas</label>
                    @if($pengaturan->logo)
                        <div class="mb-3">
                            <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo Universitas"
                                style="width:110px;height:110px;object-fit:contain;">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control-custom" accept=".png,.jpg,.jpeg">
                    <small class="text-muted">Format PNG, JPG, atau JPEG. Maksimal 2 MB.</small>
                </div>
            </div>
        </div>

        <div class="card-custom p-4 mb-3">
            <div class="section-heading">
                <i class="fa-solid fa-signature"></i>
                <h6 class="fw-bold mb-0">Informasi Penandatangan</h6>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom">Nama Pejabat</label>
                    <input type="text" name="nama_pejabat" class="form-control-custom"
                        value="{{ old('nama_pejabat', $pengaturan->nama_pejabat) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Jabatan Pejabat</label>
                    <input type="text" name="jabatan_pejabat" class="form-control-custom"
                        value="{{ old('jabatan_pejabat', $pengaturan->jabatan_pejabat) }}">
                </div>

                <div class="col-md-12">
                    <label class="form-label-custom">NIP / Identitas Pejabat</label>
                    <input type="text" name="nip" class="form-control-custom"
                        value="{{ old('nip', $pengaturan->nip) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Tanda Tangan Resmi</label>
                    @if($pengaturan->tanda_tangan)
                        <div class="mb-3">
                            <img src="{{ Storage::url($pengaturan->tanda_tangan) }}" alt="Tanda Tangan"
                                style="width:180px;height:90px;object-fit:contain;">
                        </div>
                    @endif
                    <input type="file" name="tanda_tangan" class="form-control-custom" accept=".png,.jpg,.jpeg">
                    <small class="text-muted">Gunakan file resmi yang diizinkan kampus.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label-custom">Stempel Resmi</label>
                    @if($pengaturan->stempel)
                        <div class="mb-3">
                            <img src="{{ Storage::url($pengaturan->stempel) }}" alt="Stempel"
                                style="width:110px;height:110px;object-fit:contain;">
                        </div>
                    @endif
                    <input type="file" name="stempel" class="form-control-custom" accept=".png,.jpg,.jpeg">
                    <small class="text-muted">Gunakan file stempel resmi yang diizinkan kampus.</small>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
