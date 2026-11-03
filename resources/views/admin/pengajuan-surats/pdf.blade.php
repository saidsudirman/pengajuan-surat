<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        /* 1. Optimasi Margin Halaman A4 */
        @page {
            size: A4;
            margin: 1.5cm 2cm; /* Margin atas/bawah 1.5cm, kiri/kanan 2cm */
        }

        /* 2. Optimasi Font & Jarak Baris */
        body {
            font-family: "Times New Roman", serif;
            font-size: 11.5pt; 
            color: #000;
            line-height: 1.3; 
            margin: 0;
            padding: 0;
        }

        /* 3. Kop Surat */
        .kop {
            width: 100%;
            border-bottom: 2.5px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .kop td {
            vertical-align: middle;
        }

        .logo {
            width: 75px; 
            height: auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            font-size: 14pt; 
            margin: 0;
        }

        .kop-text h3 {
            font-size: 11pt;
            margin: 2px 0;
        }

        .kop-text p {
            font-size: 8.5pt;
            margin: 1px 0;
        }

        /* 4. Judul Surat */
        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul h3 {
            text-decoration: underline;
            margin: 0 0 3px 0;
            font-size: 12pt;
        }

        .judul div {
            font-size: 11pt;
        }

        /* 5. Isi Surat dari Admin */
        .isi {
            text-align: justify;
            line-height: 1.4;
        }

        .isi p {
            orphans: 3;
            widows: 3;
        }

        /* 6. Bagian Tanda Tangan & Stempel */
        .penutup {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid; 
        }

        .ttd {
            width: 250px;
            margin-left: auto;
            text-align: center;
        }

        /* Wadah untuk menumpuk stempel dan ttd */
        .wadah-ttd {
            position: relative;
            height: 85px; /* Area tinggi untuk tumpukan gambar */
            margin: 5px 0;
        }

        /* Gambar Stempel (Di Belakang) */
        .stempel {
            position: absolute;
            height: 80px; 
            top: -5px; 
            left: 30px; /* Geser kiri-kanan */
            opacity: 0.85; /* Sedikit transparan agar ttd tetap terlihat */
            z-index: 1; 
        }

        /* Gambar Tanda Tangan (Di Depan) */
        .ttd-gambar {
            position: absolute;
            height: 65px;
            top: 15px; /* Posisi agak turun */
            left: 60px; /* Geser kiri-kanan */
            z-index: 2; 
        }

        /* Spasi kosong jika gambar tidak ada */
        .spasi-kosong {
            height: 80px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <table class="kop">
        <tr>
            <td width="90" align="center">
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
                @if($pengaturan->website)
                    <p>{{ $pengaturan->website }}</p>
                @endif
            </td>
        </tr>
    </table>

    <!-- JUDUL SURAT -->
    <div class="judul">
        <h3>{{ strtoupper($pengajuanSurat->jenisSurat->nama_surat) }}</h3>
        <div>Nomor: {{ $pengajuanSurat->nomor_pengajuan }}</div>
    </div>

    <!-- ISI SURAT (DARI ADMIN) -->
    <div class="isi">
        {!! nl2br($isiTemplate) !!}
    </div>

    <!-- TANDA TANGAN & STEMPEL -->
    <table class="penutup">
        <tr>
            <td></td>
            <td class="ttd">
                Makassar, {{ $tanggalCetak }}<br>
                {{ $pengaturan->jabatan_pejabat }}

                <!-- Wadah Tumpuk Stempel & TTD -->
                <div class="wadah-ttd">
                    @if($gambar['stempel'])
                        <img src="{{ $gambar['stempel'] }}" class="stempel">
                    @endif

                    @if($gambar['tanda_tangan'])
                        <img src="{{ $gambar['tanda_tangan'] }}" class="ttd-gambar">
                    @elseif(!$gambar['stempel'])
                        <!-- Jika tidak ada ttd dan stempel, beri spasi kosong -->
                        <div class="spasi-kosong"></div>
                    @endif
                </div>

                <strong><u>{{ $pengaturan->nama_pejabat }}</u></strong><br>

                @if($pengaturan->nip)
                    NIP. {{ $pengaturan->nip }}
                @endif
            </td>
        </tr>
    </table>

</body>
</html>