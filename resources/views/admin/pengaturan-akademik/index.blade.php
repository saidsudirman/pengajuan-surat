
@extends('layouts.admin')

@section('title', 'Pengaturan Akademik')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pengaturan Akademik</h4>
            <p class="text-muted mb-0">Atur tahun akademik dan semester yang sedang aktif.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.pengaturan-akademik.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tahun_akademik" class="form-label fw-semibold">Tahun Akademik</label>
                    <input
                        type="text"
                        class="form-control @error('tahun_akademik') is-invalid @enderror"
                        id="tahun_akademik"
                        name="tahun_akademik"
                        value="{{ old('tahun_akademik', $pengaturan->tahun_akademik ?? '2026/2027') }}"
                        placeholder="Contoh: 2026/2027"
                        required
                    >
                    @error('tahun_akademik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="semester_aktif" class="form-label fw-semibold">Semester Aktif</label>
                    <select
                        class="form-select @error('semester_aktif') is-invalid @enderror"
                        id="semester_aktif"
                        name="semester_aktif"
                        required
                    >
                        <option value="Ganjil" {{ old('semester_aktif', $pengaturan->semester_aktif ?? 'Ganjil') === 'Ganjil' ? 'selected' : '' }}>
                            Ganjil
                        </option>
                        <option value="Genap" {{ old('semester_aktif', $pengaturan->semester_aktif ?? 'Ganjil') === 'Genap' ? 'selected' : '' }}>
                            Genap
                        </option>
                    </select>
                    @error('semester_aktif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
