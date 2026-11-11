@extends('layouts.admin')

@section('title', 'Pengaturan Surat')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1>Pengaturan Surat</h1>
            <p>Kelola identitas kampus dan informasi penandatangan surat akademik.</p>
        </div>
        <button type="submit" form="formPengaturan" class="btn-primary-custom">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
        </button>
    </div>

    @if(session('success'))
        <div class="alert-custom success mb-4">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-custom error mb-4">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1" style="padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.pengaturan-surat.update') }}" method="POST" enctype="multipart/form-data" id="formPengaturan">
        @csrf
        @method('PUT')

        <div class="row g-3">
            
            {{-- KOLOM KIRI (Identitas Kampus) --}}
            <div class="col-lg-7">
                <div class="card-custom p-4 h-100">
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

                        <div class="col-12">
                            <label class="form-label-custom">Alamat Kampus</label>
                            <textarea name="alamat" rows="3" class="form-control-custom">{{ old('alamat', $pengaturan->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (Logo & Visual) --}}
            <div class="col-lg-5">
                <div class="card-custom p-4 h-100">
                    <div class="section-heading">
                        <i class="fa-solid fa-image"></i>
                        <h6 class="fw-bold mb-0">Logo Universitas</h6>
                    </div>

                    <div class="file-upload-wrapper">
                        @if($pengaturan->logo)
                            <div class="file-preview-box mb-3">
                                <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo Universitas" class="img-fluid" style="max-height: 120px; object-fit: contain;">
                            </div>
                        @else
                            <div class="file-preview-box mb-3 empty">
                                <i class="fa-regular fa-image"></i>
                                <p class="mb-0 mt-2">Belum ada logo</p>
                            </div>
                        @endif
                        
                        <input type="file" name="logo" class="form-control-custom" accept=".png,.jpg,.jpeg">
                        <small class="text-muted mt-2 d-block text-center" style="font-size: 11.5px;">
                            <i class="fa-solid fa-info-circle"></i> Format PNG, JPG, JPEG. Maks. 2 MB.
                        </small>
                    </div>
                </div>
            </div>

            {{-- KOLOM BAWAH (Penandatangan) --}}
            <div class="col-12">
                <div class="card-custom p-4">
                    <div class="section-heading">
                        <i class="fa-solid fa-signature"></i>
                        <h6 class="fw-bold mb-0">Informasi Penandatangan</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label-custom">Nama Pejabat</label>
                            <input type="text" name="nama_pejabat" class="form-control-custom"
                                value="{{ old('nama_pejabat', $pengaturan->nama_pejabat) }}">
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <label class="form-label-custom">Jabatan Pejabat</label>
                            <input type="text" name="jabatan_pejabat" class="form-control-custom"
                                value="{{ old('jabatan_pejabat', $pengaturan->jabatan_pejabat) }}">
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <label class="form-label-custom">NIP / Identitas Pejabat</label>
                            <input type="text" name="nip" class="form-control-custom"
                                value="{{ old('nip', $pengaturan->nip) }}">
                        </div>

                        {{-- Tanda Tangan --}}
                        <div class="col-md-6 mt-4">
                            <label class="form-label-custom">Tanda Tangan Resmi</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($pengaturan->tanda_tangan)
                                    <div class="file-preview-box p-2" style="width: 140px; height: 70px;">
                                        <img src="{{ Storage::url($pengaturan->tanda_tangan) }}" alt="Tanda Tangan" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="file-preview-box p-2 empty" style="width: 140px; height: 70px;">
                                        <i class="fa-solid fa-signature"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="tanda_tangan" class="form-control-custom" accept=".png,.jpg,.jpeg">
                                    <small class="text-muted d-block mt-1" style="font-size: 11px;">Gunakan file resmi kampus.</small>
                                </div>
                            </div>
                        </div>

                        {{-- Stempel --}}
                        <div class="col-md-6 mt-4">
                            <label class="form-label-custom">Stempel Resmi</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($pengaturan->stempel)
                                    <div class="file-preview-box p-2" style="width: 70px; height: 70px;">
                                        <img src="{{ Storage::url($pengaturan->stempel) }}" alt="Stempel" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                    </div>
                                @else
                                    <div class="file-preview-box p-2 empty" style="width: 70px; height: 70px;">
                                        <i class="fa-solid fa-stamp"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="stempel" class="form-control-custom" accept=".png,.jpg,.jpeg">
                                    <small class="text-muted d-block mt-1" style="font-size: 11px;">Gunakan file resmi kampus.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@section('styles')
<style>
    .section-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--slate-200);
    }

    .section-heading i {
        color: var(--primary);
        font-size: 16px;
    }

    .form-label-custom {
        display: block;
        font-weight: 700;
        font-size: 12.5px;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .form-control-custom {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid var(--slate-200);
        border-radius: 10px;
        font-family: inherit;
        font-size: 13.5px;
        color: var(--dark);
        background: white;
        outline: none;
        transition: all 0.2s;
    }

    textarea.form-control-custom {
        resize: vertical;
    }

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(201, 180, 88, 0.15);
    }

    /* File Upload & Preview */
    .file-upload-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .file-preview-box {
        width: 100%;
        background: var(--slate-100);
        border: 2px dashed var(--slate-200);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow: hidden;
    }

    .file-preview-box.empty {
        flex-direction: column;
        color: var(--slate-400);
    }

    .file-preview-box.empty i {
        font-size: 32px;
        opacity: 0.5;
    }

    .file-preview-box.empty p {
        font-size: 13px;
        font-weight: 600;
    }

    /* Custom Alert */
    .alert-custom {
        border-radius: 10px;
        padding: 14px 18px;
        border: 1px solid;
        font-size: 13.5px;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .alert-custom.success {
        background: #ECFDF5;
        border-color: #A7F3D0;
        color: #047857;
    }

    .alert-custom.error {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #B91C1C;
    }

    .alert-custom i {
        font-size: 16px;
        margin-top: 2px;
    }
</style>
@endsection\]