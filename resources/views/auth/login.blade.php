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
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>