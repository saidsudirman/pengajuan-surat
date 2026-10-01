@extends('layouts.mahasiswa')

@section('title', 'Ajukan Surat Baru')
@section('subtitle', 'Isi form dengan lengkap')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header-mhs mb-4">
        <h1>Ajukan Surat Baru</h1>
        <p>Isi data berikut untuk mengajukan surat akademik.</p>
    </div>

    @if($errors->any())
        <div class="alert-mhs error mb-3">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 mt-1" style="padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('mahasiswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card-mhs p-3 p-md-4 mb-3">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-file-lines text-primary-mhs"></i>
                        Detail Pengajuan
                    </h6>

                    <div class="mb-3">
                        <label class="form-label-custom">
                            Jenis Surat <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_surat_id" id="jenisSuratSelect"
                                class="form-control-custom @error('jenis_surat_id') is-invalid @enderror"
                                required>
                            <option value="">— Pilih Jenis Surat —</option>
                            @foreach($jenisSurats as $js)
                                <option value="{{ $js->id }}"
                                        data-deskripsi="{{ $js->deskripsi }}"
                                        {{ old('jenis_surat_id') == $js->id ? 'selected' : '' }}>
                                    {{ $js->nama_surat }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_surat_id')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror

                        <div id="deskripsiSurat" class="info-box-mhs mt-2 d-none">
                            <small></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">
                            Keperluan Pengajuan <span class="text-danger">*</span>
                        </label>
                        <textarea name="keperluan" rows="4"
                                  class="form-control-custom @error('keperluan') is-invalid @enderror"
                                  placeholder="Jelaskan keperluan Anda mengajukan surat ini (min. 10 karakter)..."
                                  required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback-custom">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="card-mhs p-3 p-md-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-paperclip text-primary-mhs"></i>
                        Dokumen Pendukung
                    </h6>

                    <p class="text-muted mb-3 form-hint">
                        Upload dokumen pendukung (opsional). Format: PDF, JPG, PNG. Maks. 2MB per file.
                    </p>

                    <input type="file" name="dokumen[]" id="dokumenInput" multiple
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="form-control-custom">

                    <div id="previewFiles" class="mt-3"></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-mhs p-3 p-md-4 mb-3 sticky-card">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user text-primary-mhs"></i>
                        Data Mahasiswa
                    </h6>

                    <div class="info-row">
                        <small class="info-row-label">Nama</small>
                        <div class="info-row-value">{{ $mahasiswa->nama }}</div>
                    </div>
                    <div class="info-row">
                        <small class="info-row-label">NIM</small>
                        <div class="info-row-value">{{ $mahasiswa->nim }}</div>
                    </div>
                    <div class="info-row">
                        <small class="info-row-label">Program Studi</small>
                        <div class="info-row-value">{{ $mahasiswa->program_studi }}</div>
                    </div>
                    <div class="info-row">
                        <small class="info-row-label">Fakultas</small>
                        <div class="info-row-value">{{ $mahasiswa->fakultas ?? '-' }}</div>
                    </div>
                    <div class="info-row-last">
                        <small class="info-row-label">Semester</small>
                        <div class="info-row-value">{{ $mahasiswa->semester ?? '-' }}</div>
                    </div>
                </div>

                <div class="card-mhs help-card">
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <i class="fa-solid fa-circle-info help-icon"></i>
                        <h6 class="fw-bold mb-0 help-title">Informasi</h6>
                    </div>
                    <p class="mb-0 help-desc">
                        Pastikan data yang Anda isi sudah benar. Pengajuan akan diproses oleh admin akademik dalam 1-3 hari kerja.
                    </p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('mahasiswa.pengajuan.index') }}" class="btn-mhs-outline">
                <i class="fa-solid fa-xmark"></i> Batal
            </a>
            <button type="submit" class="btn-mhs-primary">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan
            </button>
        </div>
    </form>

</div>

@endsection

@section('styles')
<style>
    .text-primary-mhs { color: var(--primary) !important; }

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

    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(201, 180, 88, 0.15);
    }

    .form-control-custom.is-invalid {
        border-color: #DC2626;
        background: #FEF2F2;
    }

    textarea.form-control-custom { resize: vertical; }

    .invalid-feedback-custom {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        margin-top: 6px;
    }

    .info-box-mhs {
        padding: 12px 14px;
        background: var(--primary-light);
        border-left: 3px solid var(--primary);
        border-radius: 10px;
        color: var(--primary-dark);
        font-size: 12.5px;
        line-height: 1.5;
    }

    .form-hint { font-size: 12.5px; }

    .sticky-card {
        position: sticky;
        top: 90px;
    }

    .info-row {
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--slate-200);
    }

    .info-row-last { padding-bottom: 0; }

    .info-row-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--slate-500);
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
    }

    .info-row-value {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--dark);
    }

    .help-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        color: white;
        padding: 20px;
    }

    .help-icon { color: white; font-size: 14px; margin-top: 2px; }
    .help-title { font-size: 13.5px; color: white; }
    .help-desc {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('jenisSuratSelect');
    const deskripsiBox = document.getElementById('deskripsiSurat');

    select?.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const deskripsi = opt.dataset.deskripsi;

        if (deskripsi && deskripsi.trim() !== '') {
            deskripsiBox.querySelector('small').textContent = deskripsi;
            deskripsiBox.classList.remove('d-none');
        } else {
            deskripsiBox.classList.add('d-none');
        }
    });

    const input = document.getElementById('dokumenInput');
    const preview = document.getElementById('previewFiles');

    input?.addEventListener('change', function() {
        preview.innerHTML = '';
        if (this.files.length === 0) return;

        const info = document.createElement('div');
        info.className = 'text-muted mb-2';
        info.style.fontSize = '12px';
        info.textContent = this.files.length + ' file dipilih:';
        preview.appendChild(info);

        Array.from(this.files).forEach(file => {
            const size = (file.size / 1024).toFixed(1);
            const item = document.createElement('div');
            item.className = 'file-preview-item';
            item.innerHTML = '<i class="fa-solid fa-file text-primary-mhs"></i><span class="file-name">' + file.name + '</span><span class="file-size">' + size + ' KB</span>';
            preview.appendChild(item);
        });
    });
});
</script>

<style>
    .file-preview-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: var(--slate-100);
        border-radius: 8px;
        margin-bottom: 6px;
        font-size: 12.5px;
    }
    .file-name { flex: 1; font-weight: 600; }
    .file-size { color: var(--slate-500); font-size: 11px; }
</style>
@endsection