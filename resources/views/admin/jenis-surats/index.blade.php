@extends('layouts.admin')

@section('title', 'Jenis Surat')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Jenis Surat</h3>
            <p class="text-muted mb-0">
                Kelola jenis surat akademik.
            </p>
        </div>

        <a href="{{ route('admin.jenis-surats.create') }}"
           class="btn btn-primary">
            Tambah Jenis Surat
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Surat</th>
                        <th>Deskripsi</th>
                        <th>Template</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($jenisSurats as $jenisSurat)

                        <tr>

                            <td>
                                {{ $jenisSurats->firstItem() + $loop->index }}
                            </td>

                            <td class="fw-semibold">
                                {{ $jenisSurat->nama_surat }}
                            </td>

                            <td>
                                {{ Str::limit($jenisSurat->deskripsi ?? '-', 50) }}
                            </td>

                            <td>
                                {{ $jenisSurat->template_surat ?? '-' }}
                            </td>

                            <td>

                                @if($jenisSurat->status === 'aktif')
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Tidak Aktif
                                    </span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.jenis-surats.edit', $jenisSurat) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.jenis-surats.destroy', $jenisSurat) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                Belum ada jenis surat.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($jenisSurats->hasPages())
            <div class="card-footer bg-white">
                {{ $jenisSurats->links() }}
            </div>
        @endif

    </div>

</div>
@endsection