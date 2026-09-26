<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMBAH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --simba-green: #39755c;
            --simba-green-dark: #2d604a;
            --simba-ink: #24352d;
        }

        body {
            background: #f4f7f4 !important;
            color: var(--simba-ink);
            font-family: 'Nunito Sans', sans-serif;
        }

        .login-card {
            border: 1px solid #dfe8e1;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(42, 75, 57, 0.08);
        }

        .login-title {
            font-weight: 800;
        }

        .form-control {
            min-height: 44px;
            border-color: #cbd8ce;
        }

        .form-control:focus {
            border-color: #78a68b;
            box-shadow: 0 0 0 0.2rem rgba(57, 117, 92, 0.14);
        }

        .btn-success {
            background: var(--simba-green);
            border-color: var(--simba-green);
            font-weight: 700;
        }

        .btn-success:hover {
            background: var(--simba-green-dark);
            border-color: var(--simba-green-dark);
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-3 login-title">SIMBAH</h4>
                        <p class="text-center text-muted small mb-4">Sistem Informasi & Manajemen Bank Sampah</p>

                        @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="loginPassword" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
                                        <svg class="password-eye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg class="password-eye-off d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 3 18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.7 10.7 0 0 1 12 5c6.4 0 10 7 10 7a15.8 15.8 0 0 1-3.1 3.9"/><path d="M6.6 6.6C3.6 8.6 2 12 2 12s3.6 7 10 7a10.4 10.4 0 0 0 4.1-.8"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Login</button>
                        </form>
                        <p class="text-center text-muted small mt-3 mb-0">Belum punya akun? Hubungi admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('loginPassword');
        const passwordToggle = document.getElementById('togglePassword');

        passwordToggle.addEventListener('click', function() {
            const isVisible = passwordInput.type === 'text';
            passwordInput.type = isVisible ? 'password' : 'text';
            passwordToggle.setAttribute('aria-pressed', String(!isVisible));
            passwordToggle.setAttribute('aria-label', isVisible ? 'Tampilkan password' : 'Sembunyikan password');
            passwordToggle.querySelector('.password-eye').classList.toggle('d-none', !isVisible);
            passwordToggle.querySelector('.password-eye-off').classList.toggle('d-none', isVisible);
        });
    </script>
</body>

</html>