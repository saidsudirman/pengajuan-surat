@extends('layouts.admin')

@section('title', 'Pengajuan Surat')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Pengajuan Surat</h3>
        <p class="text-muted mb-0">
            Kelola pengajuan surat mahasiswa
        </p>
    </div>
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
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Pengajuan</th>
                        <th>Mahasiswa</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pengajuans as $pengajuan)

                        <tr>
                            <td>
                                {{ $pengajuans->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>
                                    {{ $pengajuan->nomor_pengajuan }}
                                </strong>
                            </td>

                            <td>
                                {{ $pengajuan->mahasiswa->nama ?? '-' }}
                                <br>
                                <small class="text-muted">
                                    {{ $pengajuan->mahasiswa->nim ?? '-' }}
                                </small>
                            </td>

                            <td>
                                {{ $pengajuan->jenisSurat->nama_surat ?? '-' }}
                            </td>

                            <td>
                                {{ $pengajuan->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                @if($pengajuan->status === 'menunggu')
                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>
                                @elseif($pengajuan->status === 'diproses')
                                    <span class="badge bg-info">
                                        Diproses
                                    </span>
                                @elseif($pengajuan->status === 'diterima')
                                    <span class="badge bg-success">
                                        Diterima
                                    </span>
                                @elseif($pengajuan->status === 'ditolak')
                                    <span class="badge bg-danger">
                                        Ditolak
                                    </span>
                                @elseif($pengajuan->status === 'selesai')
                                    <span class="badge bg-primary">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.pengajuan-surats.show', $pengajuan) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    Belum ada pengajuan surat.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $pengajuans->links() }}
        </div>

    </div>
</div>

@endsection