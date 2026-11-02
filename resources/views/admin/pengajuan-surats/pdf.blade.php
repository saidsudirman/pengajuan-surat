
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
            margin: 2cm 2.5cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.5;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .kop td {
            vertical-align: middle;
        }

        .logo {
            width: 85px;
            height: 85px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            font-size: 16pt;
            margin: 0;
        }

        .kop-text h3 {
            font-size: 13pt;
            margin: 3px 0;
        }

        .kop-text p {
            font-size: 9pt;
            margin: 2px 0;
        }

        .judul {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul h3 {
            text-decoration: underline;
            margin-bottom: 3px;
        }

        .isi {
            text-align: justify;
            white-space: pre-line;
            line-height: 1.7;
        }

        .penutup {
            width: 100%;
            margin-top: 35px;
        }

        .ttd {
            width: 250px;
            margin-left: auto;
            text-align: center;
        }

        .ttd-gambar {
            height: 65px;
            margin: 5px 0;
        }

        .stempel {
            height: 75px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <table class="kop">
        <tr>
            <td width="100" align="center">
                @if($gambar['logo'])
                    <img src="{{ $gambar['logo'] }}" class="logo">
                @endif
            </td>
            <td class="kop-text">
                @if($pengaturan->nama_yayasan)
                    <h3>{{ strtoupper($pengaturan->nama_yayasan) }}</h3>
                @endif

                <h2>{{ strtoupper($pengaturan->nama_universitas) }}</h2>

                @if($pengaturan->nama_unit)
                    <h3>{{ strtoupper($pengaturan->nama_unit) }}</h3>
                @endif

                <p>{{ $pengaturan->alamat }}</p>
                <p>
                    {{ $pengaturan->telepon }}
                    {{ $pengaturan->email ? ' | ' . $pengaturan->email : '' }}
                </p>
                <p>{{ $pengaturan->website }}</p>
            </td>
        </tr>
    </table>

    <div class="judul">
        <h3>{{ strtoupper($pengajuanSurat->jenisSurat->nama_surat) }}</h3>
        <div>Nomor Pengajuan: {{ $pengajuanSurat->nomor_pengajuan }}</div>
    </div>

    <div class="isi">{!! nl2br($isiTemplate) !!}</div>

    <table class="penutup">
        <tr>
            <td></td>
            <td class="ttd">
                Makassar, {{ $tanggalCetak }}<br>
                {{ $pengaturan->jabatan_pejabat }}

                @if($gambar['stempel'])
                    <br>
                    <img src="{{ $gambar['stempel'] }}" class="stempel">
                @endif

                @if($gambar['tanda_tangan'])
                    <br>
                    <img src="{{ $gambar['tanda_tangan'] }}" class="ttd-gambar">
                @else
                    <br><br><br><br>
                @endif

                <strong><u>{{ $pengaturan->nama_pejabat }}</u></strong><br>

                @if($pengaturan->nip)
                    NIP. {{ $pengaturan->nip }}
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
