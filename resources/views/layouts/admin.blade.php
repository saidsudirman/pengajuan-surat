<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin') - Sistem Pengajuan Surat
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f7fb;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1e293b;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 25px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sidebar-menu {
            padding: 20px 15px;
        }

        .sidebar-title {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            margin: 10px 10px;
            text-transform: uppercase;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #334155;
            color: white;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            height: 70px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .content {
            padding: 30px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .logout-btn {
            border: none;
            background: none;
            color: #64748b;
            padding: 0;
        }

        .logout-btn:hover {
            color: #dc2626;
        }

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
            }

            .sidebar-brand span,
            .sidebar a span,
            .sidebar-title {
                display: none;
            }

            .sidebar a {
                justify-content: center;
            }

            .main-content {
                margin-left: 70px;
            }

            .content {
                padding: 20px;
            }
        }

    </style>

</head>

<body>

    <aside class="sidebar">

        <div class="sidebar-brand">
            <i class="fa-solid fa-graduation-cap me-2"></i>
            <span>Surat Akademik</span>
        </div>

        <div class="sidebar-menu">

            <div class="sidebar-title">
                Menu Utama
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('admin.jenis-surats.index') }}"
                class="{{ request()->routeIs('admin.jenis-surats.*') ? 'active' : '' }}"
            >
                <i class="fa-solid fa-file-lines"></i>
                <span>Jenis Surat</span>
            </a>

            <a href="{{ route('admin.mahasiswa.index') }}">
                <i class="fa-solid fa-users"></i>
                <span>Mahasiswa</span>
            </a>

            <a href="{{ route('admin.pengajuan-surats.index') }}">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span>Pengajuan Surat</span>
            </a>

            <div class="sidebar-title mt-4">
                Sistem
            </div>

            <a href="#">
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf

                <button
                    type="submit"
                    class="logout-btn w-100 text-start"
                >
                    <a href="javascript:void(0)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </button>

            </form>

        </div>

    </aside>


    <div class="main-content">

        <header class="topbar">

            <div>
                <h5 class="mb-0 fw-bold">
                    @yield('title', 'Dashboard')
                </h5>
            </div>

            <div class="user-info">

                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div>
                    <div class="fw-semibold">
                        {{ auth()->user()->name }}
                    </div>

                    <small class="text-muted">
                        Administrator
                    </small>
                </div>

            </div>

        </header>


        <main class="content">

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

            @yield('content')

        </main>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>