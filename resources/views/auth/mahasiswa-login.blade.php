<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Mahasiswa - Sistem Pengajuan Surat</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">

            <div class="card shadow border-0">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Login Mahasiswa</h3>
                        <p class="text-muted">
                            Sistem Informasi Pengajuan Surat Akademik
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.mahasiswa.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email mahasiswa"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >
                        </div>

                        <div class="mb-3 form-check">
                            <input
                                type="checkbox"
                                name="remember"
                                class="form-check-input"
                                id="remember"
                            >

                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button class="btn btn-success w-100">
                            Login Mahasiswa
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login.admin') }}">
                            Login sebagai Admin
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>