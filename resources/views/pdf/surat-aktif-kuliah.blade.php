<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Aktif Kuliah</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 2.2cm;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.35;
        }


        .kop {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }

        .kop-tabel {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .kop-tabel td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo {
            width: 100px;
            text-align: left;
        }

        .logo {
            width: 85px;
            height: auto;
        }

        .kop-teks {
            text-align: center;
        }

        .yayasan {
            font-size: 12pt;
            font-weight: bold;
        }

        .kampus {
            font-size: 16pt;
            font-weight: bold;
        }

        .alamat {
            font-size: 10pt;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        .no {
            width: 25px;
        }

        .label {
            width: 165px;
        }

        .titik {
            width: 12px;
        }

        .penutup {
            margin-top: 18px;
            text-align: justify;
        }

                .ttd {
            width: 45%;
            margin-left: auto; /* Membuat posisi di sebelah kanan */
            margin-top: 35px;
            text-align: left;
        }

        /* Class khusus untuk barcode/QR Code */
        .barcode-ttd {
            width: 85px; /* Ukuran QR Code, sesuaikan jika terlalu besar/kecil */
            height: auto;
            display: block;
            margin-top: 8px; /* Jarak antara teks "Pejabat berwenang" dan QR Code */
            margin-bottom: 5px;
        }

        .nama-pejabat {
            margin-top: 10px; /* Jarak antara QR Code dan nama pejabat */
            font-weight: bold;
            text-decoration: underline;
        }

        .tembusan {
            margin-top: 25px;
            font-size: 10pt;
        }
    </style>
</head>

<body>

    <div class="kop">
        <table class="kop-tabel">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('images/logo-dipa.png') }}" class="logo"
                        alt="Logo Universitas Dipa Makassar">
                </td>
                <td class="kop-teks">
                    <div class="yayasan">YAYASAN DIPANEGARA</div>
                    <div class="kampus">UNIVERSITAS DIPA MAKASSAR</div>
                    <div class="alamat">
                        Jl. Perintis Kemerdekaan IX KM. 9 Makassar<br>
                        Tlp. 0411-587194
                    </div>
                </td>
                <td style="width: 100px;"></td>
            </tr>
        </table>
    </div>


    <div class="judul">SURAT KETERANGAN AKTIF KULIAH</div>
    <div class="nomor">
        Nomor: {{ $nomorSurat }}
    </div>

    <p>Yang bertanda tangan di bawah ini:</p>

    <table>
        <tr>
            <td class="no">1.</td>
            <td class="label">Nama</td>
            <td class="titik">:</td>
            <td>{{ $namaPejabat }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">NIP/NIDN</td>
            <td class="titik">:</td>
            <td>{{ $nipPejabat ?: '-' }}</td>
        </tr>
        <tr>
            <td class="no">3.</td>
            <td class="label">Jabatan</td>
            <td class="titik">:</td>
            <td>{{ $jabatanPejabat }}</td>
        </tr>
    </table>

    <p>Dengan ini menyatakan dengan sesungguhnya bahwa mahasiswa:</p>

    <table>
        <tr>
            <td class="no">4.</td>
            <td class="label">NIM</td>
            <td class="titik">:</td>
            <td>{{ $mahasiswa->nim }}</td>
        </tr>
        <tr>
            <td class="no">5.</td>
            <td class="label">Nama</td>
            <td class="titik">:</td>
            <td>{{ strtoupper($mahasiswa->nama) }}</td>
        </tr>
        <tr>
            <td class="no">6.</td>
            <td class="label">No. Handphone</td>
            <td class="titik">:</td>
            <td>{{ $mahasiswa->no_hp ?: '-' }}</td>
        </tr>
        <tr>
            <td class="no">7.</td>
            <td class="label">Program Studi</td>
            <td class="titik">:</td>
            <td>{{ $mahasiswa->program_studi ?: '-' }}</td>
        </tr>
        <tr>
            <td class="no">8.</td>
            <td class="label">Perguruan Tinggi</td>
            <td class="titik">:</td>
            <td>Universitas Dipa Makassar</td>
        </tr>
        <tr>
            <td class="no">9.</td>
            <td class="label">Semester</td>
            <td class="titik">:</td>
            <td>{{ $semester ?: '-' }}</td>
        </tr>
        <tr>
            <td class="no">10.</td>
            <td class="label">Periode</td>
            <td class="titik">:</td>
            <td>{{ $periode ?: '-' }}</td>
        </tr>
    </table>

    <p class="penutup">
        Demikian surat keterangan ini dibuat dengan sesungguhnya
        untuk dipergunakan sebagaimana mestinya.
    </p>

            <div class="ttd">
        Makassar, {{ $tanggalSurat }}<br>
        a.n. Rektor<br>
        Pejabat berwenang<br>
        
        <!-- Barcode/QR Code diletakkan di sini -->
        <img src="{{ public_path('images/image.png') }}" class="barcode-ttd" alt="QR Code">
        
        <!-- Nama pejabat didorong ke bawah dengan margin-top -->
        <div class="nama-pejabat">{{ $namaPejabat }}</div>
    </div>

    <div class="tembusan">
        Tembusan:<br>
        1. BAAK<br>
        2. Arsip
    </div>
</body>

</html>