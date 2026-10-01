@extends('layouts.admin')

@section('title', 'Tambah Jenis Surat')

@section('content')

<div class="container-fluid p-0">

    {{-- Page Header with Breadcrumb --}}
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="breadcrumb-inline mb-2">
                <a href="{{ route('admin.jenis-surats.index') }}">Jenis Surat</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Tambah</span>
            </div>
            <h1>Tambah Jenis Surat</h1>
            <p>Tambahkan jenis surat akademik baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('admin.jenis-surats.index') }}" class="btn-outline-custom">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-3">
        {{-- Main Form --}}
        <div class="col-lg-8">
            <div class="card-custom p-4">

                <div class="form-section-header">
                    <div class="form-section-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Informasi Jenis Surat</h6>
                        <small class="text-muted" style="font-size: 12.5px;">
                            Isi detail jenis surat yang akan ditambahkan
                        </small>
                    </div>
                </div>

                <form action="{{ route('admin.jenis-surats.store') }}" method="POST" id="formJenisSurat">
                    @csrf

                    {{-- Nama Surat --}}
                    <div class="mb-4">
                        <label class="form-label-custom">
                            Nama Surat <span class="text-danger">*</span>
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-heading input-icon"></i>
                            <input type="text"
                                   name="nama_surat"
                                   value="{{ old('nama_surat') }}"
                                   class="form-control-custom @error('nama_surat') is-invalid @enderror"
                                   placeholder="Contoh: Surat Keterangan Aktif Kuliah"
                                   required>
                        </div>
                        @error('nama_surat')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Deskripsi</label>
                        <textarea name="deskripsi"
                                  rows="5"
                                  class="form-control-custom @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan kegunaan dan persyaratan jenis surat ini..."
                                  style="padding-left: 16px; resize: vertical;">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted" style="font-size: 11.5px;">
                            <i class="fa-solid fa-info-circle"></i> Opsional, namun membantu mahasiswa memahami kegunaan surat.
                        </small>
                    </div>

                    {{-- Template Surat --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Template Surat</label>
                        <div class="input-icon-wrapper">
                            <i class="fa-solid fa-file-word input-icon"></i>
                            <input type="text"
                                   name="template_surat"
                                   value="{{ old('template_surat') }}"
                                   class="form-control-custom @error('template_surat') is-invalid @enderror"
                                   placeholder="Contoh: surat-aktif-kuliah.docx">
                        </div>
                        @error('template_surat')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted" style="font-size: 11.5px;">
                            <i class="fa-solid fa-info-circle"></i> Nama file template surat (opsional).
                        </small>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Status</label>
                        <div class="status-radio-group">
                            <label class="status-radio {{ old('status', 'aktif') === 'aktif' ? 'active' : '' }}">
                                <input type="radio"
                                       name="status"
                                       value="aktif"
                                       @checked(old('status', 'aktif') === 'aktif')>
                                <span class="status-radio-content">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="status-radio-title">Aktif</span>
                                    <span class="status-radio-desc">Tersedia untuk pengajuan</span>
                                </span>
                            </label>

                            <label class="status-radio {{ old('status') === 'tidak_aktif' ? 'active' : '' }}">
                                <input type="radio"
                                       name="status"
                                       value="tidak_aktif"
                                       @checked(old('status') === 'tidak_aktif')>
                                <span class="status-radio-content">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    <span class="status-radio-title">Tidak Aktif</span>
                                    <span class="status-radio-desc">Disembunyikan sementara</span>
                                </span>
                            </label>
                        </div>
                        @error('status')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="form-actions">
                        <a href="{{ route('admin.jenis-surats.index') }}" class="btn-outline-custom">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Jenis Surat
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- Info Sidebar --}}
        <div class="col-lg-4">
            <div class="card-custom p-4 mb-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="stat-icon red" style="width: 42px; height: 42px; font-size: 16px;">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0" style="font-size: 14px;">Tips</h6>
                        <small class="text-muted" style="font-size: 11.5px;">Informasi penting</small>
                    </div>
                </div>
                <ul class="tips-list">
                    <li>Gunakan nama surat yang jelas dan deskriptif</li>
                    <li>Deskripsi membantu mahasiswa memahami kegunaan</li>
                    <li>Pastikan template surat sudah tersedia di server</li>
                    <li>Nonaktifkan jenis surat jika sedang tidak digunakan</li>
                </ul>
            </div>

            <div class="card-custom p-4" style="background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%); border: none;">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-circle-info" style="color: var(--primary);"></i>
                        <h6 class="fw-bold mb-0" style="font-size: 13.5px;">Status Aktif</h6>
                    </div>
                    <p class="mb-0" style="font-size: 12.5px; color: #CBD5E1; line-height: 1.6;">
                        Jenis surat dengan status <strong style="color: white;">Aktif</strong> akan
                        langsung muncul di halaman pengajuan mahasiswa.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    /* Breadcrumb Inline */
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

    .breadcrumb-inline span {
        color: var(--primary);
        font-weight: 700;
    }

    /* Form Section Header */
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

    /* Form Label */
    .form-label-custom {
        display: block;
        font-weight: 700;
        font-size: 12.5px;
        color: var(--dark);
        margin-bottom: 8px;
        letter-spacing: 0.2px;
    }

    /* Form Control */
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
        box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
    }

    .form-control-custom.is-invalid {
        border-color: #DC2626;
        background: #FEF2F2;
    }

    /* Input Icon */
    .input-icon-wrapper {
        position: relative;
    }

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

    .input-icon-wrapper .form-control-custom {
        padding-left: 44px;
    }

    .input-icon-wrapper .form-control-custom:focus ~ .input-icon {
        color: var(--primary);
    }

    /* Invalid Feedback */
    .invalid-feedback-custom {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
    }

    /* Status Radio */
    .status-radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .status-radio {
        position: relative;
        cursor: pointer;
        margin: 0;
    }

    .status-radio input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-radio-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
        padding: 14px 16px;
        border: 1.5px solid var(--slate-200);
        border-radius: 12px;
        background: #F8FAFC;
        transition: var(--transition);
        position: relative;
    }

    .status-radio-content i {
        font-size: 16px;
        color: var(--slate-400);
        margin-bottom: 4px;
        transition: var(--transition);
    }

    .status-radio-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--dark);
    }

    .status-radio-desc {
        font-size: 11px;
        color: var(--slate-500);
        line-height: 1.4;
    }

    .status-radio:hover .status-radio-content {
        border-color: var(--slate-400);
        background: white;
    }

    .status-radio input:checked ~ .status-radio-content {
        border-color: var(--primary);
        background: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
    }

    .status-radio input:checked ~ .status-radio-content i {
        color: var(--primary);
    }

    .status-radio input:checked ~ .status-radio-content .status-radio-title {
        color: var(--primary-dark);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid var(--slate-200);
        margin-top: 4px;
    }

    /* Tips List */
    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tips-list li {
        position: relative;
        padding-left: 22px;
        margin-bottom: 10px;
        font-size: 12.5px;
        color: var(--slate-700);
        line-height: 1.5;
    }

    .tips-list li::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 1px;
        font-size: 10px;
        color: var(--primary);
    }

    .tips-list li:last-child { margin-bottom: 0; }

    /* Responsive */
    @media (max-width: 575.98px) {
        .status-radio-group { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .form-actions .btn-outline-custom,
        .form-actions .btn-primary-custom { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('scripts')
<script>
    // Update active state on radio change
    document.querySelectorAll('.status-radio input').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.status-radio').forEach(label => {
                label.classList.toggle('active', label.querySelector('input').checked);
            });
        });
    });
</script>
@endsection