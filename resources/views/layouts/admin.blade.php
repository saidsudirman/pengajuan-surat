<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Sistem Pengajuan Surat</title>

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
            --dark-2: #0F172A;
            --slate-700: #334155;
            --slate-500: #64748B;
            --slate-400: #94A3B8;
            --slate-200: #E2E8F0;
            --slate-100: #F1F5F9;
            --bg: #F8FAFC;
            --white: #FFFFFF;

            --sidebar-w: 260px;
            --sidebar-collapsed: 78px;
            --radius: 14px;
            --radius-sm: 10px;

            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.03), 0 1px 3px 0 rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -2px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 12px 28px -8px rgba(201, 180, 88, 0.15), 0 4px 12px -4px rgba(0, 0, 0, 0.05);
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
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, #1E293B 0%, #0F172A 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar-brand {
            height: 72px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 22px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        /* ====== PERBAIKAN: CSS LOGO ====== */
        .sidebar-brand .brand-logo {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }
        /* ====== END PERBAIKAN ====== */

        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .sidebar-brand-text .title {
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .sidebar-brand-text .subtitle {
            font-size: 10px;
            color: var(--slate-400);
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .sidebar.collapsed .sidebar-brand-text {
            opacity: 0;
            pointer-events: none;
            width: 0;
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .sidebar-title {
            color: var(--slate-400);
            font-size: 10px;
            font-weight: 700;
            margin: 16px 12px 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .sidebar.collapsed .sidebar-title {
            opacity: 0;
            height: 0;
            margin: 8px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #CBD5E1;
            text-decoration: none;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            margin-bottom: 3px;
            transition: var(--transition);
            font-size: 13.5px;
            font-weight: 500;
            position: relative;
            white-space: nowrap;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white;
        }

        .sidebar-menu a.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 6px 16px -4px rgba(201, 180, 88, 0.5);
            color: white;
        }

        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: -14px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 22px;
            background: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .sidebar-menu a .badge-menu {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 50px;
        }

        .sidebar.collapsed .sidebar-menu a span:not(.badge-menu) {
            opacity: 0;
            pointer-events: none;
            width: 0;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .sidebar-menu a .badge-menu {
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 9px;
            padding: 1px 5px;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.2);
            color: #FCA5A5;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .logout-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .sidebar.collapsed .logout-btn {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .logout-btn span {
            opacity: 0;
            width: 0;
            pointer-events: none;
        }

        /* ============ MAIN CONTENT ============ */
        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* ============ TOPBAR ============ */
        .topbar {
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

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            min-width: 0;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--slate-500);
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .sidebar-toggle:hover {
            background: var(--slate-100);
            color: var(--primary);
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--slate-500);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .breadcrumb-custom .current {
            color: var(--dark);
            font-weight: 700;
        }

        .breadcrumb-custom i {
            font-size: 10px;
            color: var(--slate-400);
        }

        .search-wrapper {
            flex: 0 1 380px;
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate-400);
            font-size: 13px;
            pointer-events: none;
        }

        .search-wrapper input {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border: 1px solid var(--slate-200);
            border-radius: 50px;
            background: var(--slate-100);
            font-family: inherit;
            font-size: 13px;
            color: var(--dark);
            transition: var(--transition);
            outline: none;
        }

        .search-wrapper input::placeholder {
            color: var(--slate-400);
        }

        .search-wrapper input:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(201, 180, 88, 0.15);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .icon-btn {
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
        }

        .icon-btn:hover {
            background: var(--slate-100);
            color: var(--primary);
        }

        .icon-btn .dot {
            position: absolute;
            top: 9px;
            right: 10px;
            width: 7px;
            height: 7px;
            background: var(--primary);
            border-radius: 50%;
            border: 2px solid white;
        }

        .profile-trigger {
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

        .profile-trigger:hover {
            background: var(--slate-100);
            border-color: var(--slate-200);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(201, 180, 88, 0.3);
        }

        .user-meta {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            text-align: left;
        }

        .user-meta .name {
            font-size: 13px;
            font-weight: 700;
            color: var(--dark);
        }

        .user-meta .role {
            font-size: 11px;
            color: var(--slate-500);
        }

        .dropdown-menu-custom {
            border: 1px solid var(--slate-200);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-lg);
            padding: 6px;
            min-width: 220px;
            margin-top: 8px;
        }

        .dropdown-menu-custom .dropdown-item {
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

        .dropdown-menu-custom .dropdown-item:hover {
            background: var(--slate-100);
            color: var(--dark);
        }

        .dropdown-menu-custom .dropdown-item.text-danger:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .dropdown-menu-custom .dropdown-item i {
            width: 16px;
            font-size: 13px;
        }

        .dropdown-menu-custom .dropdown-divider {
            margin: 6px 0;
            border-color: var(--slate-200);
        }

        .content {
            padding: 28px;
            flex: 1;
        }

        .card-custom {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .card-custom:hover {
            box-shadow: var(--shadow-md);
        }

        .stat-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            padding: 22px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .stat-icon.red { background: #FEE2E2; color: #DC2626; }
        .stat-icon.orange { background: #FEF3C7; color: #D97706; }
        .stat-icon.blue { background: #DBEAFE; color: #2563EB; }
        .stat-icon.green { background: #D1FAE5; color: #059669; }
        .stat-icon.gray { background: #F1F5F9; color: #64748B; }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 12.5px;
            color: var(--slate-500);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 50px;
            margin-top: 10px;
        }

        .stat-trend.up { background: #D1FAE5; color: #059669; }
        .stat-trend.down { background: #FEE2E2; color: #DC2626; }
        .stat-trend.neutral { background: #F1F5F9; color: #64748B; }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px -2px rgba(201, 180, 88, 0.35);
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px -4px rgba(201, 180, 88, 0.45);
            color: white;
        }

        .btn-outline-custom {
            background: white;
            color: var(--slate-700);
            border: 1px solid var(--slate-200);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-outline-custom:hover {
            background: var(--slate-100);
            border-color: var(--slate-400);
            color: var(--dark);
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        .table-modern thead th {
            background: var(--slate-100);
            color: var(--slate-500);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--slate-200);
            white-space: nowrap;
            text-align: left;
        }

        .table-modern thead th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .table-modern thead th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .table-modern tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--slate-100);
            color: var(--slate-700);
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: var(--transition);
        }

        .table-modern tbody tr:hover {
            background: #FAFBFC;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .badge-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .badge-menunggu { background: #FEF3C7; color: #B45309; }
        .badge-diproses { background: #DBEAFE; color: #1D4ED8; }
        .badge-diterima { background: #E0E7FF; color: #4338CA; }
        .badge-selesai  { background: #D1FAE5; color: #047857; }
        .badge-ditolak  { background: #FEE2E2; color: #B91C1C; }

        .hover-lift {
            transition: var(--transition);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .page-header p {
            font-size: 13.5px;
            color: var(--slate-500);
            margin: 0;
        }

        .greeting-banner {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border-radius: var(--radius);
            padding: 28px 32px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .greeting-banner::before {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(201, 180, 88, 0.25), transparent 70%);
            border-radius: 50%;
        }

        .greeting-banner::after {
            content: '';
            position: absolute;
            right: 80px;
            bottom: -80px;
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, rgba(201, 180, 88, 0.15), transparent 70%);
            border-radius: 50%;
        }

        .greeting-banner h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 2;
        }

        .greeting-banner p {
            color: #CBD5E1;
            font-size: 13.5px;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .topbar {
                padding: 0 16px;
            }

            .search-wrapper {
                flex: 1;
                max-width: none;
            }

            .content {
                padding: 20px 16px;
            }

            .user-meta {
                display: none;
            }

            .profile-trigger {
                padding: 4px;
            }

            .breadcrumb-custom {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .topbar {
                height: 64px;
                padding: 0 12px;
                gap: 8px;
            }

            .search-wrapper {
                display: none;
            }

            .content {
                padding: 16px 12px;
            }

            .stat-value {
                font-size: 22px;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .greeting-banner {
                padding: 20px;
            }

            .greeting-banner h2 {
                font-size: 18px;
            }

            .page-header h1 {
                font-size: 18px;
            }
        }

        .alert-custom {
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            border: 1px solid;
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .alert-custom.success {
            background: #ECFDF5;
            border-color: #A7F3D0;
            color: #047857;
        }

        .alert-custom.error {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #B91C1C;
        }
    </style>
    @yield('styles')
</head>

<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo Universitas DIPA Makassar">
            </div>
            <div class="sidebar-brand-text">
                <span class="title">Surat Akademik</span>
                <span class="subtitle">UNIV. DIPA MAKASSAR</span>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="sidebar-title">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.pengajuan-surats.index') }}"
                class="{{ request()->routeIs('admin.pengajuan-surats.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span>Pengajuan Surat</span>
            </a>

            <a href="{{ route('admin.jenis-surats.index') }}"
                class="{{ request()->routeIs('admin.jenis-surats.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i>
                <span>Jenis Surat</span>
            </a>

            <a href="{{ route('admin.mahasiswa.index') }}"
                class="{{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                <span>Mahasiswa</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="main-content" id="mainContent">

        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="breadcrumb-custom">
                    <span>Admin</span>
                    <i class="fa-solid fa-chevron-right"></i>
                    <span class="current">@yield('title', 'Dashboard')</span>
                </div>

                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari pengajuan, mahasiswa...">
                </div>
            </div>

            <div class="topbar-right">
                <button class="icon-btn" title="Notifikasi">
                    <i class="fa-regular fa-bell"></i>
                    <span class="dot"></span>
                </button>

                <button class="icon-btn" title="Pesan">
                    <i class="fa-regular fa-envelope"></i>
                </button>

                <div class="dropdown">
                    <button class="profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-meta">
                            <span class="name">{{ auth()->user()->name }}</span>
                            <span class="role">Administrator</span>
                        </div>
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: var(--slate-400);"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-regular fa-user"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-gear"></i> Pengaturan
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

        <main class="content">
            @if(session('success'))
                <div class="alert-custom success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-custom error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        sidebarToggle.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                sidebar.classList.toggle('mobile-open');
                sidebarBackdrop.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
        });

        sidebarBackdrop.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
            sidebarBackdrop.classList.remove('show');
        });

        if (window.innerWidth >= 992) {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('mobile-open');
                sidebarBackdrop.classList.remove('show');
            }
        });
    </script>
    @yield('scripts')
</body>

</html>