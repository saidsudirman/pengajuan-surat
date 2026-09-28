@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Data Mahasiswa</h3>
        <p class="text-muted mb-0">
            Kelola data mahasiswa dan akun login
        </p>
    </div>

    <a href="{{ route('admin.mahasiswa.create') }}"
       class="btn btn-primary">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Mahasiswa
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        @if($mahasiswas->count())

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($mahasiswas as $mahasiswa)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() }}
                            </td>

                            <td>
                                <span class="fw-semibold">
                                    {{ $mahasiswa->nim }}
                                </span>
                            </td>

                            <td>
                                {{ $mahasiswa->nama }}
                            </td>

                            <td>
                                {{ $mahasiswa->user->email ?? '-' }}
                            </td>

                            <td>
                                {{ $mahasiswa->program_studi }}
                            </td>

                            <td>
                                {{ $mahasiswa->angkatan ?? '-' }}
                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    <a
                                        href="{{ route('admin.mahasiswa.show', $mahasiswa) }}"
                                        class="btn btn-sm btn-info text-white"
                                        title="Detail"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Edit"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}"
                                        method="POST"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $mahasiswas->links() }}
            </div>

        @else

            <div class="text-center py-5">

                <i class="fa-solid fa-users fa-3x text-muted mb-3"></i>

                <h5>Belum Ada Data Mahasiswa</h5>

                <p class="text-muted">
                    Silakan tambahkan mahasiswa terlebih dahulu.
                </p>

                <a
                    href="{{ route('admin.mahasiswa.create') }}"
                    class="btn btn-primary"
                >
                    <i class="fa-solid fa-plus me-1"></i>
                    Tambah Mahasiswa
                </a>

            </div>

        @endif

    </div>

</div>

@endsection