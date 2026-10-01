@extends('layouts.mahasiswa')

@section('title', 'Panduan')
@section('subtitle', 'Petunjuk penggunaan sistem')

@section('content')

<div class="container-fluid p-0">

    <div class="page-header-mhs mb-4">
        <h1>Panduan Penggunaan</h1>
        <p>Cara mengajukan surat akademik dengan benar.</p>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">

            {{-- Langkah Pengajuan --}}
            <div class="card-mhs p-3 p-md-4 mb-3">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-list-ol text-primary-mhs"></i>
                    Langkah Pengajuan Surat
                </h6>

                @php
                    $steps = [
                        ['title' => 'Login ke Sistem',              'desc' => 'Masuk menggunakan email dan password yang telah diberikan oleh admin akademik.'],
                        ['title' => 'Pilih Menu "Ajukan Surat"',    'desc' => 'Klik tombol "Ajukan Surat Baru" pada dashboard atau menu di sidebar.'],
                        ['title' => 'Pilih Jenis Surat',            'desc' => 'Pilih jenis surat yang ingin diajukan. Pastikan jenis surat sesuai dengan kebutuhan Anda.'],
                        ['title' => 'Isi Keperluan',                'desc' => 'Jelaskan keperluan pengajuan surat dengan detail (minimal 10 karakter).'],
                        ['title' => 'Upload Dokumen Pendukung',     'desc' => 'Jika diperlukan, upload dokumen pendukung dalam format PDF, JPG, atau PNG (maks. 2MB).'],
                        ['title' => 'Kirim Pengajuan',              'desc' => 'Klik tombol "Kirim Pengajuan" dan tunggu verifikasi dari admin akademik.'],
                        ['title' => 'Pantau Status',                'desc' => 'Cek status pengajuan di menu "Riwayat Pengajuan". Anda akan mendapat informasi saat status berubah.'],
                        ['title' => 'Download Surat',               'desc' => 'Jika status sudah "Selesai", surat dapat diunduh di halaman detail pengajuan.'],
                    ];
                @endphp

                @foreach($steps as $i => $s)
                <div class="step-item {{ $i < count($steps) - 1 ? 'step-item-border' : '' }}">
                    <div class="step-number">{{ $i + 1 }}</div>
                    <div>
                        <div class="step-title">{{ $s['title'] }}</div>
                        <div class="step-desc">{{ $s['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- FAQ --}}
            <div class="card-mhs p-3 p-md-4">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-question text-primary-mhs"></i>
                    Pertanyaan Umum (FAQ)
                </h6>

                @php
                    $faqs = [
                        ['q' => 'Berapa lama proses pengajuan surat?', 'a' => 'Rata-rata 1-3 hari kerja tergantung jenis surat dan kelengkapan dokumen.'],
                        ['q' => 'Apa yang harus dilakukan jika pengajuan ditolak?', 'a' => 'Cek catatan admin pada halaman detail pengajuan, perbaiki data sesuai catatan, lalu ajukan ulang.'],
                        ['q' => 'Bagaimana jika salah memilih jenis surat?', 'a' => 'Batalkan pengajuan (jika masih berstatus "Menunggu") lalu ajukan ulang dengan jenis surat yang benar.'],
                        ['q' => 'Apakah bisa mengajukan lebih dari satu surat sekaligus?', 'a' => 'Bisa, tetapi sebaiknya satu per satu agar admin mudah memverifikasi.'],
                        ['q' => 'Dokumen apa saja yang perlu diupload?', 'a' => 'Tergantung jenis surat. Cek deskripsi jenis surat saat memilih di form pengajuan.'],
                    ];
                @endphp

                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $i => $f)
                    <div class="accordion-item faq-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button faq-button {{ $i !== 0 ? 'collapsed' : '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $i }}">
                                {{ $f['q'] }}
                            </button>
                        </h2>
                        <div id="faq{{ $i }}"
                             class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body faq-answer">
                                {{ $f['a'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Butuh Bantuan --}}
            <div class="card-mhs help-card mb-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fa-solid fa-headset help-icon"></i>
                    <h6 class="fw-bold mb-0 help-title">Butuh Bantuan?</h6>
                </div>
                <p class="mb-3 help-desc">
                    Jika mengalami kendala, hubungi admin akademik.
                </p>

                <div class="help-contact">
                    <div class="help-contact-label">Email</div>
                    <div class="help-contact-value">akademik@dipamakassar.ac.id</div>
                </div>

                <div class="help-contact">
                    <div class="help-contact-label">Telepon</div>
                    <div class="help-contact-value">(0411) 123-4567</div>
                </div>
            </div>

            {{-- Jam Layanan --}}
            <div class="card-mhs p-3 p-md-4">
                <h6 class="fw-bold mb-3 schedule-title">Jam Layanan</h6>

                <div class="schedule-row">
                    <span class="schedule-day">Senin - Kamis</span>
                    <span class="schedule-time">08.00 - 16.00</span>
                </div>

                <div class="schedule-row">
                    <span class="schedule-day">Jumat</span>
                    <span class="schedule-time">08.00 - 14.00</span>
                </div>

                <div class="schedule-row-last">
                    <span class="schedule-day">Sabtu - Minggu</span>
                    <span class="schedule-time schedule-closed">Tutup</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    .text-primary-mhs { color: var(--primary) !important; }

    /* ============ STEP LIST ============ */
    .step-item {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
        padding-bottom: 12px;
    }

    .step-item-border {
        border-bottom: 1px dashed var(--slate-200);
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        flex-shrink: 0;
    }

    .step-title {
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--dark);
    }

    .step-desc {
        font-size: 12.5px;
        color: var(--slate-500);
        line-height: 1.6;
    }

    /* ============ FAQ ============ */
    .faq-item {
        border: 1px solid var(--slate-200);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .faq-button {
        font-size: 13.5px;
        font-weight: 700;
        box-shadow: none;
        background: white;
        color: var(--dark);
        padding: 14px 16px;
    }

    .faq-button:not(.collapsed) {
        background: var(--primary-light);
        color: var(--primary-dark);
    }

    .faq-button:focus {
        box-shadow: none;
        border-color: var(--primary);
    }

    .faq-answer {
        font-size: 12.5px;
        line-height: 1.6;
        color: var(--slate-500);
        padding: 12px 16px;
    }

    /* ============ HELP CARD ============ */
    .help-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        color: white;
    }

    .help-icon {
        font-size: 18px;
        color: white;
    }

    .help-title {
        font-size: 14px;
        color: white;
    }

    .help-desc {
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
    }

    .help-contact {
        padding: 12px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        margin-bottom: 8px;
    }

    .help-contact:last-child { margin-bottom: 0; }

    .help-contact-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 2px;
    }

    .help-contact-value {
        font-size: 12.5px;
        font-weight: 700;
        color: white;
        word-break: break-word;
    }

    /* ============ SCHEDULE ============ */
    .schedule-title {
        font-size: 13.5px;
    }

    .schedule-row {
        display: flex;
        justify-content: space-between;
        padding-bottom: 8px;
        margin-bottom: 8px;
        border-bottom: 1px solid var(--slate-100);
    }

    .schedule-row-last {
        display: flex;
        justify-content: space-between;
    }

    .schedule-day {
        font-size: 12.5px;
        color: var(--slate-500);
    }

    .schedule-time {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--dark);
    }

    .schedule-closed {
        color: #DC2626;
    }
</style>
@endsection