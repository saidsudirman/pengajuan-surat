<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mahasiswa') - Sistem Pengajuan Surat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #C9B458;
            --primary-dark: #B09A3E;
            --primary-light: #F9F6E8;
            --dark: #1E293B;
            --slate-700: #334155;
            --slate-500: #64748B;
            --slate-400: #94A3B8;
            --slate-200: #E2E8F0;
            --slate-100: #F1F5F9;
            --bg: #F8FAFC;
            --white: #FFFFFF;
            --sidebar-w: 260px;
            --radius: 14px;
            --radius-sm: 10px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px -2px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 12px 28px -8px rgba(201, 180, 88, 0.18), 0 4px 12px -4px rgba(0, 0, 0, 0.05);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--dark);
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            padding-bottom: 80px;
            /* ruang untuk bottom-nav mobile */
        }

        /* ============ SIDEBAR (LIGHT VERSION) ============ */
        .sidebar-mhs {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--white);
            border-right: 1px solid var(--slate-200);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
        }

        .sidebar-mhs-brand {
            height: 72px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 22px;
            border-bottom: 1px solid var(--slate-200);
            flex-shrink: 0;
        }

        .sidebar-mhs-brand .brand-logo {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-mhs-brand .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .sidebar-mhs-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .sidebar-mhs-brand-text .title {
            font-size: 14px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.3px;
        }

        .sidebar-mhs-brand-text .subtitle {
            font-size: 10px;
            color: var(--slate-500);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .sidebar-mhs-menu {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
        }

        .sidebar-mhs-title {
            font-size: 10px;
            font-weight: 700;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 12px;
            margin-top: 8px;
        }

        .sidebar-mhs-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            color: var(--slate-700);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 3px;
            transition: var(--transition);
            position: relative;
        }

        .sidebar-mhs-menu a:hover {
            background: var(--slate-100);
            color: var(--dark);
        }

        .sidebar-mhs-menu a.active {
            background: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 700;
        }

        .sidebar-mhs-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-mhs-menu a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-mhs-menu a .badge-count {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 50px;
        }

        /* User Info at Sidebar Bottom */
        .sidebar-mhs-user {
            padding: 16px;
            border-top: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .sidebar-mhs-user .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-mhs-user .info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-mhs-user .info .name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-mhs-user .info .nim {
            font-size: 11px;
            color: var(--slate-500);
            font-weight: 500;
        }

        /* ============ MAIN CONTENT ============ */
        .main-mhs {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ============ TOPBAR ============ */
        .topbar-mhs {
            height: 72px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1020;
            gap: 20px;
        }

        .topbar-mhs-left {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }

        .topbar-mhs-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.3px;
        }

        .topbar-mhs-subtitle {
            font-size: 12px;
            color: var(--slate-500);
            font-weight: 500;
        }

        .topbar-mhs-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .icon-btn-mhs {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: transparent;
            border: none;
            color: var(--slate-500);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
        }

        .icon-btn-mhs:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .icon-btn-mhs .dot {
            position: absolute;
            top: 9px;
            right: 10px;
            width: 7px;
            height: 7px;
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Profile Dropdown */
        .profile-mhs-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 12px 5px 5px;
            border-radius: 50px;
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
        }

        .profile-mhs-trigger:hover {
            background: var(--slate-100);
            border-color: var(--slate-200);
        }

        .profile-mhs-trigger .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(201, 180, 88, 0.3);
        }

        .profile-mhs-trigger .meta {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            text-align: left;
        }

        .profile-mhs-trigger .meta .name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
        }

        .profile-mhs-trigger .meta .role {
            font-size: 11px;
            color: var(--slate-500);
        }

        /* Dropdown Menu */
        .dropdown-mhs {
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-lg);
            padding: 6px;
            min-width: 220px;
            margin-top: 8px;
        }

        .dropdown-mhs .dropdown-item {
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            font-weight: 500;
            color: var(--slate-700);
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
        }

        .dropdown-mhs .dropdown-item:hover {
            background: var(--slate-100);
            color: var(--dark);
        }

        .dropdown-mhs .dropdown-item.text-danger:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .dropdown-mhs .dropdown-item i {
            width: 16px;
            font-size: 13px;
        }

        /* ============ CONTENT ============ */
        .content-mhs {
            padding: 28px;
            flex: 1;
        }

        /* Card Custom */
        .card-mhs {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .card-mhs:hover {
            box-shadow: var(--shadow-md);
        }

        /* Buttons */
        .btn-mhs-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 11px 20px;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px -2px rgba(201, 180, 88, 0.4);
        }

        .btn-mhs-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px -4px rgba(201, 180, 88, 0.5);
            color: white;
        }

        .btn-mhs-outline {
            background: white;
            color: var(--slate-700);
            border: 1.5px solid var(--slate-200);
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-mhs-outline:hover {
            background: var(--slate-100);
            border-color: var(--slate-400);
            color: var(--dark);
        }

        /* Page Header */
        .page-header-mhs {
            margin-bottom: 24px;
        }

        .page-header-mhs h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .page-header-mhs p {
            font-size: 13.5px;
            color: var(--slate-500);
            margin: 0;
        }

        /* Alert */
        .alert-mhs {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .alert-mhs.success {
            background: #ECFDF5;
            border-color: #A7F3D0;
            color: #047857;
        }

        .alert-mhs.error {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #B91C1C;
        }

        .alert-mhs.info {
            background: var(--primary-light);
            border-color: rgba(201, 180, 88, 0.3);
            color: var(--primary-dark);
        }

        /* ============ BOTTOM NAVIGATION (MOBILE) ============ */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 68px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--slate-200);
            z-index: 1030;
            padding: 0 8px;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.04);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 8px 12px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--slate-500);
            font-size: 10px;
            font-weight: 600;
            transition: var(--transition);
            flex: 1;
            position: relative;
        }

        .bottom-nav-item i {
            font-size: 18px;
            transition: var(--transition);
        }

        .bottom-nav-item:hover {
            color: var(--primary-dark);
        }

        .bottom-nav-item.active {
            color: var(--primary-dark);
        }

        .bottom-nav-item.active i {
            color: var(--primary);
            transform: translateY(-2px);
        }

        .bottom-nav-item.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 3px;
            background: var(--primary);
            border-radius: 0 0 4px 4px;
        }

        /* Bottom nav FAB (Floating Action Button) */
        .bottom-nav-fab {
            position: relative;
            flex: 0 0 68px;
        }

        .bottom-nav-fab .fab {
            position: absolute;
            top: -22px;
            left: 50%;
            transform: translateX(-50%);
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px -4px rgba(201, 180, 88, 0.55);
            text-decoration: none;
            transition: var(--transition);
            border: 4px solid var(--bg);
        }

        .bottom-nav-fab .fab:hover {
            transform: translateX(-50%) translateY(-2px);
            box-shadow: 0 12px 25px -6px rgba(201, 180, 88, 0.65);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 991.98px) {
            .sidebar-mhs {
                transform: translateX(-100%);
                width: var(--sidebar-w);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            }

            .sidebar-mhs.mobile-open {
                transform: translateX(0);
            }

            .main-mhs {
                margin-left: 0;
            }

            .topbar-mhs {
                padding: 0 16px;
            }

            .content-mhs {
                padding: 20px 16px;
            }

            .profile-mhs-trigger .meta {
                display: none;
            }

            .profile-mhs-trigger {
                padding: 4px;
            }

            .bottom-nav {
                display: flex;
            }

            body {
                padding-bottom: 84px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar-mhs {
                height: 64px;
                padding: 0 12px;
            }

            .topbar-mhs-title {
                font-size: 14px;
            }

            .topbar-mhs-subtitle {
                display: none;
            }

            .content-mhs {
                padding: 16px 12px;
            }

            .page-header-mhs h1 {
                font-size: 18px;
            }

            .bottom-nav-item span {
                font-size: 9px;
            }
        }

        /* Backdrop mobile sidebar */
        .sidebar-mhs-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-mhs-backdrop.show {
            display: block;
            opacity: 1;
        }

        @media (min-width: 992px) {
            .sidebar-mhs-backdrop {
                display: none !important;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    {{-- ============ SIDEBAR MAHASISWA ============ --}}
    <aside class="sidebar-mhs" id="sidebarMhs">
        <div class="sidebar-mhs-brand">
            <div class="brand-logo">
                <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo Universitas DIPA Makassar">
            </div>
            <div class="sidebar-mhs-brand-text">
                <span class="title">Surat Akademik</span>
                <span class="subtitle">UNIV. DIPA MAKASSAR</span>
            </div>
        </div>

        <div class="sidebar-mhs-menu">
            <div class="sidebar-mhs-title">Menu Utama</div>

            <a href="{{ route('mahasiswa.dashboard') }}"
                class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('mahasiswa.pengajuan.create') }}"
                class="{{ request()->routeIs('mahasiswa.pengajuan.create') ? 'active' : '' }}">
                <i class="fa-solid fa-file-circle-plus"></i>
                <span>Ajukan Surat</span>
            </a>

            <a href="{{ route('mahasiswa.pengajuan.index') }}"
                class="{{ request()->routeIs('mahasiswa.pengajuan.index') || request()->routeIs('mahasiswa.pengajuan.show') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Riwayat Pengajuan</span>
                @if(isset($totalPengajuanAktif) && $totalPengajuanAktif > 0)
                    <span class="badge-count">{{ $totalPengajuanAktif }}</span>
                @endif
            </a>

            <div class="sidebar-mhs-title">Akun</div>

            <a href="{{ route('mahasiswa.profil') }}"
                class="{{ request()->routeIs('mahasiswa.profil') ? 'active' : '' }}">
                <i class="fa-regular fa-user"></i>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('mahasiswa.panduan') }}"
                class="{{ request()->routeIs('mahasiswa.panduan') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-question"></i>
                <span>Panduan</span>
            </a>
        </div>

        <div class="sidebar-mhs-user">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="info">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="nim">{{ auth()->user()->mahasiswa->nim ?? 'Mahasiswa' }}</div>
            </div>
        </div>
    </aside>

    {{-- Backdrop Mobile --}}
    <div class="sidebar-mhs-backdrop" id="sidebarMhsBackdrop"></div>

    {{-- ============ MAIN CONTENT ============ --}}
    <div class="main-mhs">

        {{-- ============ TOPBAR ============ --}}
        <header class="topbar-mhs">
            <div class="topbar-mhs-left">
                {{-- Mobile menu toggle --}}
                <button class="icon-btn-mhs d-lg-none" id="sidebarMhsToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>
                    <div class="topbar-mhs-title">@yield('title', 'Dashboard')</div>
                    <div class="topbar-mhs-subtitle d-none d-md-block">
                        @yield('subtitle', 'Sistem Pengajuan Surat Akademik')
                    </div>
                </div>
            </div>

            <div class="topbar-mhs-right">

                {{-- Profile Dropdown --}}
                <div class="dropdown">
                    <button class="profile-mhs-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="meta">
                            <span class="name">{{ auth()->user()->name }}</span>
                            <span class="role">{{ auth()->user()->mahasiswa->nim ?? 'Mahasiswa' }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down d-none d-md-inline"
                            style="font-size: 10px; color: var(--slate-400);"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-mhs">
                        <li>
                            <a class="dropdown-item" href="{{ route('mahasiswa.profil') }}">
                                <i class="fa-regular fa-user"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('mahasiswa.panduan') }}">
                                <i class="fa-regular fa-circle-question"></i> Panduan
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item text-danger w-100 text-start border-0 bg-transparent">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        {{-- ============ CONTENT ============ --}}
        <main class="content-mhs">
            @if(session('success'))
                <div class="alert-mhs success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-mhs error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- ============ BOTTOM NAVIGATION (MOBILE) ============ --}}
    <nav class="bottom-nav">
        <a href="{{ route('mahasiswa.dashboard') }}"
            class="bottom-nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </a>

        <a href="{{ route('mahasiswa.pengajuan.index') }}"
            class="bottom-nav-item {{ request()->routeIs('mahasiswa.pengajuan.index') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Riwayat</span>
        </a>

        {{-- FAB untuk Ajukan Surat --}}
        <div class="bottom-nav-fab">
            <a href="{{ route('mahasiswa.pengajuan.create') }}" class="fab" title="Ajukan Surat Baru">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        <a href="{{ route('mahasiswa.profil') }}"
            class="bottom-nav-item {{ request()->routeIs('mahasiswa.profil') ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i>
            <span>Profil</span>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar mobile
        const sidebarMhs = document.getElementById('sidebarMhs');
        const sidebarMhsToggle = document.getElementById('sidebarMhsToggle');
        const sidebarMhsBackdrop = document.getElementById('sidebarMhsBackdrop');

        sidebarMhsToggle?.addEventListener('click', function () {
            sidebarMhs.classList.toggle('mobile-open');
            sidebarMhsBackdrop.classList.toggle('show');
        });

        sidebarMhsBackdrop?.addEventListener('click', function () {
            sidebarMhs.classList.remove('mobile-open');
            sidebarMhsBackdrop.classList.remove('show');
        });

        // Tutup sidebar saat resize ke desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebarMhs.classList.remove('mobile-open');
                sidebarMhsBackdrop.classList.remove('show');
            }
        });
    </script>
    @yield('scripts')
</body>

</html>