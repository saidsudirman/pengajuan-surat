
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 35px 45px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #111;
        }

        .kop {
            text-align: center;
            border-bottom: 3px double #111;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .kop h2, .kop h3, .kop p {
            margin: 2px 0;
        }

        .judul {
            text-align: center;
            margin: 25px 0;
        }

        .judul h3 {
            text-decoration: underline;
            margin-bottom: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data td {
            padding: 4px;
            vertical-align: top;
        }

        .ttd {
            width: 270px;
            margin-left: auto;
            margin-top: 45px;
            text-align: center;
        }

        .ttd img {
            max-width: 100px;
            max-height: 65px;
        }

        .cap {
            max-width: 90px;
            max-height: 65px;
        }

        .catatan {
            margin-top: 30px;
            font-size: 9pt;
            color: #444;
        }
    </style>
</head>
<body>

<div class="kop">
    @if($logoPath)
        <img src="{{ $logoPath }}" class="logo" alt="Logo Kampus">
    @endif

    <h2>UNIVERSITAS DIPA MAKASSAR</h2>
    <h3>{{ strtoupper($pengajuan->jenisSurat->nama_surat) }}</h3>
    <p>Nomor: {{ $pengajuan->nomor_surat }}</p>
</div>

<div class="judul">
    <h3>{{ strtoupper($pengajuan->jenisSurat->nama_surat) }}</h3>
    <p>Nomor: {{ $pengajuan->nomor_surat }}</p>
</div>

<p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

<table class="data">
    <tr>
        <td width="160">Nama</td>
        <td width="10">:</td>
        <td>{{ $pengajuan->mahasiswa->nama }}</td>
    </tr>
    <tr>
        <td>NIM</td>
        <td>:</td>
        <td>{{ $pengajuan->mahasiswa->nim }}</td>
    </tr>
    <tr>
        <td>Program Studi</td>
        <td>:</td>
        <td>{{ $pengajuan->mahasiswa->program_studi }}</td>
    </tr>
    <tr>
        <td>Fakultas</td>
        <td>:</td>
        <td>{{ $pengajuan->mahasiswa->fakultas ?? '-' }}</td>
    </tr>
</table>

<p>
    Surat ini diterbitkan untuk keperluan:
    <strong>{{ $pengajuan->keperluan }}</strong>.
</p>

<p>
    Surat dibuat secara otomatis berdasarkan data yang tersimpan
    pada Sistem Informasi Pengajuan Surat Akademik Mahasiswa.
</p>

<div class="ttd">
    <p>Makassar, {{ $pengajuan->tanggal_selesai?->translatedFormat('d F Y') }}</p>
    <p>Pejabat yang berwenang,</p>

    @if($tandaTanganPath)
        <img src="{{ $tandaTanganPath }}" alt="Tanda tangan resmi">
    @else
        <br><br><br>
    @endif

    @if($capPath)
        <br>
        <img src="{{ $capPath }}" class="cap" alt="Cap resmi">
    @endif

    <p><strong>Nama pejabat sesuai ketentuan kampus</strong></p>
    <p>Jabatan pejabat berwenang</p>
</div>

<div class="catatan">
    Dokumen ini diterbitkan oleh sistem. Keabsahan tanda tangan elektronik
    harus mengikuti mekanisme dan kewenangan resmi kampus.
</div>

</body>
</html>
