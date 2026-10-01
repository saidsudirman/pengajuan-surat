<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - Universitas DIPA Makassar</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Warna Universitas DIPA Makassar */
            --primary: #C9B458;
            --primary-dark: #B09A3E;
            --primary-light: #F9F6E8;
            --dark: #2B2B2B;
            --dark-2: #3F3F3F;
            --gray-light: #F3F4F6;
            --gray-mid: #9CA3AF;
            --shadow-sm: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 20px 40px -10px rgba(201, 180, 88, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== SPLIT SCREEN ===== */
        .login-split {
            display: flex;
            width: 100%;
            min-height: 100vh;
            background: #ffffff;
        }

        /* ===== LEFT PANEL (BRANDING) ===== */
        .left-panel {
            flex: 1 1 50%;
            background: linear-gradient(145deg, #C9B458 0%, #B09A3E 60%, #8C7A2E 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -200px;
            right: -150px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 480px;
            width: 100%;
            text-align: center;
            color: white;
        }

        .brand-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            margin-bottom: 2rem;
        }

        .brand-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: white;
            border-radius: 50%;
            padding: 6px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .brand-logo span {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .illustration {
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .illustration svg {
            width: 100%;
            max-width: 280px;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.15));
        }

        .brand-tagline h2 {
            font-weight: 700;
            font-size: 1.9rem;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .brand-tagline p {
            font-size: 1rem;
            opacity: 0.92;
            line-height: 1.7;
            max-width: 380px;
            margin: 0 auto;
        }

        .brand-features {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            backdrop-filter: blur(4px);
        }

        /* ===== RIGHT PANEL (FORM) ===== */
        .right-panel {
            flex: 1 1 50%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 2.25rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid #F3F4F6;
            transition: box-shadow 0.3s ease;
            animation: fadeSlideUp 0.6s ease forwards;
        }

        .form-wrapper:hover {
            box-shadow: var(--shadow-md);
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: left;
        }

        .badge-role {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            margin-bottom: 1rem;
        }

        .form-header h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--gray-mid);
            font-size: 0.95rem;
        }

        .alert-custom {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #B91C1C;
            border-radius: 12px;
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .form-group { margin-bottom: 1.35rem; }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-wrapper .input-icon {
            position: absolute;
            left: 16px;
            color: var(--gray-mid);
            font-size: 1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .input-icon-wrapper input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #E5E7EB;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--dark);
            background: #F9FAFB;
            transition: all 0.25s ease;
            outline: none;
        }

        .input-icon-wrapper input::placeholder { color: #B0B7C3; }

        .input-icon-wrapper input:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(201, 180, 88, 0.18);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--gray-mid);
            cursor: pointer;
            font-size: 1.05rem;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
            z-index: 5;
        }

        .toggle-password:hover { color: var(--primary-dark); }

        .form-check-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5rem;
        }

        .form-check-custom input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .form-check-custom label {
            font-size: 0.9rem;
            color: #4B5563;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-login {
            width: 100%;
            padding: 0.95rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 20px -6px rgba(201, 180, 88, 0.5);
            letter-spacing: 0.2px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -8px rgba(201, 180, 88, 0.6);
        }

        .btn-login:active { transform: translateY(0); }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.75rem 0 1.25rem;
            color: #D1D5DB;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }

        .admin-link {
            text-align: center;
            font-size: 0.9rem;
            color: #6B7280;
            font-weight: 500;
        }

        .admin-link a {
            color: var(--primary-dark);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .admin-link a:hover {
            color: #8C7A2E;
            text-decoration: underline;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .login-split { flex-direction: column; }
            .left-panel { flex: none; padding: 2.5rem 1.5rem; min-height: auto; }
            .brand-logo img { width: 80px; height: 80px; }
            .brand-logo span { font-size: 1.25rem; }
            .illustration svg { max-width: 200px; }
            .brand-tagline h2 { font-size: 1.5rem; }
            .brand-tagline p { font-size: 0.95rem; }
            .right-panel { flex: none; padding: 2rem 1.25rem 3rem; }
            .form-wrapper { padding: 2rem 1.5rem; border-radius: 20px; }
        }

        @media (max-width: 575.98px) {
            .left-panel { padding: 2rem 1rem; }
            .brand-tagline h2 { font-size: 1.3rem; }
            .brand-tagline p { font-size: 0.85rem; }
            .feature-item span { display: none; }
            .feature-item { padding: 0.6rem; border-radius: 50%; width: 40px; height: 40px; justify-content: center; }
            .form-wrapper { padding: 1.75rem 1.25rem; }
            .form-header h1 { font-size: 1.5rem; }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<div class="login-split">
    <!-- ========== LEFT PANEL: BRANDING ========== -->
    <div class="left-panel">
        <div class="brand-content">
            <!-- Logo Universitas DIPA Makassar -->
            <div class="brand-logo">
                <!-- Ganti src dengan logo asli: {{ asset('images/logo-dipa.png') }} -->
                <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo Universitas DIPA Makassar">
                <span>Universitas DIPA Makassar</span>
            </div>

            <!-- Ilustrasi SVG -->
            <div class="illustration">
                <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="40" y="60" width="320" height="200" rx="16" fill="white" fill-opacity="0.15"/>
                    <rect x="60" y="80" width="280" height="160" rx="12" fill="white" fill-opacity="0.1"/>
                    <rect x="110" y="110" width="180" height="120" rx="10" fill="white" fill-opacity="0.9"/>
                    <path d="M110 120 L200 180 L290 120" stroke="#B09A3E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <rect x="110" y="110" width="180" height="120" rx="10" stroke="#B09A3E" stroke-width="4" fill="none"/>
                    <line x1="140" y1="150" x2="230" y2="150" stroke="#B09A3E" stroke-width="4" stroke-linecap="round" opacity="0.4"/>
                    <line x1="140" y1="170" x2="260" y2="170" stroke="#B09A3E" stroke-width="4" stroke-linecap="round" opacity="0.3"/>
                    <line x1="140" y1="190" x2="210" y2="190" stroke="#B09A3E" stroke-width="4" stroke-linecap="round" opacity="0.3"/>
                    <circle cx="280" cy="110" r="28" fill="#C9B458"/>
                    <path d="M268 110 L276 118 L292 102" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="80" cy="100" r="6" fill="white" opacity="0.4"/>
                    <circle cx="330" cy="200" r="8" fill="white" opacity="0.3"/>
                    <circle cx="100" cy="240" r="5" fill="white" opacity="0.3"/>
                    <circle cx="320" cy="80" r="7" fill="white" opacity="0.4"/>
                </svg>
            </div>

            <!-- Tagline -->
            <div class="brand-tagline">
                <h2>Ajukan Surat Akademik<br>Lebih Cepat & Mudah</h2>
                <p>
                    Sistem informasi pengajuan surat akademik terintegrasi untuk mahasiswa. 
                    Proses cepat, transparan, dan tanpa antre.
                </p>
            </div>

            <!-- Fitur singkat -->
            <div class="brand-features">
                <div class="feature-item">
                    <i class="fas fa-bolt"></i>
                    <span>Proses Cepat</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Aman</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Mobile Friendly</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== RIGHT PANEL: FORM LOGIN ========== -->
    <div class="right-panel">
        <div class="form-wrapper">
            <div class="form-header">
                <span class="badge-role">Mahasiswa</span>
                <h1>Selamat Datang</h1>
                <p>Silakan masuk untuk mengajukan surat akademik</p>
            </div>

            @if ($errors->any())
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.mahasiswa.submit') }}" method="POST" id="loginForm">
                @csrf

                <!-- Email / Username -->
                <div class="form-group">
                    <label for="email">Email / NIM</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}" 
                            placeholder="nama@mahasiswa.ac.id" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            placeholder="Masukkan password" 
                            required
                        >
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="form-check-custom">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login Mahasiswa
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="admin-link">
                <a href="{{ route('login.admin') }}">
                    <i class="fas fa-user-shield"></i>
                    Login sebagai Admin
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        });
    });
</script>

</body>
</html>