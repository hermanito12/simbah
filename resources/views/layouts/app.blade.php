<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIMBAH')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            font-size: 17px;
            --simba-green: #39755c;
            --simba-green-dark: #2d604a;
            --simba-ink: #24352d;
            --simba-muted: #68756e;
            --simba-background: #f4f7f4;
            --simba-border: #dfe8e1;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            line-height: 1.6;
            font-family: 'Nunito Sans', sans-serif;
            color: var(--simba-ink);
            background: var(--simba-background) !important;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0;
        }

        .nav-link {
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 6px;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        .nav-link:hover,
        .nav-link:focus {
            background: rgba(255, 255, 255, 0.14);
        }

        .bg-success {
            background-color: var(--simba-green) !important;
        }

        .page-heading {
            margin-bottom: 0.25rem;
            letter-spacing: 0;
        }

        .page-intro {
            margin-bottom: 1.5rem;
            color: var(--simba-muted);
        }

        .card {
            border: 1px solid var(--simba-border);
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(42, 75, 57, 0.06);
        }

        h3,
        h4,
        h5,
        h6 {
            color: var(--simba-ink);
            font-weight: 800;
        }

        .text-muted {
            color: var(--simba-muted) !important;
        }

        .table td,
        .table th {
            padding: 0.9rem 0.75rem;
            vertical-align: middle;
        }

        .table thead th {
            color: #53635a;
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            background: #f1f6f2;
            border-bottom-color: var(--simba-border);
        }

        .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .btn {
            padding: 0.5rem 1.1rem;
            border-radius: 6px;
            font-weight: 700;
        }

        .btn-success {
            --bs-btn-bg: var(--simba-green);
            --bs-btn-border-color: var(--simba-green);
            --bs-btn-hover-bg: var(--simba-green-dark);
            --bs-btn-hover-border-color: var(--simba-green-dark);
            --bs-btn-active-bg: var(--simba-green-dark);
            --bs-btn-active-border-color: var(--simba-green-dark);
        }

        .btn-outline-success {
            --bs-btn-color: var(--simba-green);
            --bs-btn-border-color: #9ab9a6;
            --bs-btn-hover-bg: var(--simba-green);
            --bs-btn-hover-border-color: var(--simba-green);
        }

        .form-control,
        .form-select {
            min-height: 44px;
            border-color: #cbd8ce;
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #78a68b;
            box-shadow: 0 0 0 0.2rem rgba(57, 117, 92, 0.14);
        }

        .dropdown-menu {
            border: 1px solid var(--simba-border);
            border-radius: 6px;
            box-shadow: 0 8px 20px rgba(42, 75, 57, 0.12);
            padding: 0.35rem;
        }

        .dropdown-item {
            border-radius: 4px;
            padding: 0.55rem 0.75rem;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #edf5ef;
            color: var(--simba-ink);
        }

        .btn-action {
            min-width: 78px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.45em 0.75em;
        }

        .badge-soft-red {
            background-color: #fde2e4;
            color: #9b3a4b;
        }

        .badge-soft-blue {
            background-color: #dbeafe;
            color: #315b8a;
        }

        .badge-soft-green {
            background-color: #dcfce7;
            color: #2f6b45;
        }

        .badge-soft-yellow {
            background-color: #fef3c7;
            color: #80621a;
        }

        .badge-soft-gray {
            background-color: #eef1f4;
            color: #59636e;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-success mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand mb-0 h1" href="{{ url('/') }}">SIMBAH</a>

            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto ms-md-4 mt-2 mt-md-0">
                    @if (auth()->user()->role === 'admin')
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.units.index') }}">Unit</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Akun</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.jenis-sampah.index') }}">Jenis Sampah</a></li>
                    @elseif (auth()->user()->role === 'pengurus')
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.transaksi.create') }}">Setoran</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.transaksi.index') }}">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.nasabah.index') }}">Nasabah</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.harga.index') }}">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pengurus.rekap.index') }}">Rekap</a></li>
                    @elseif (auth()->user()->role === 'nasabah')
                    <li class="nav-item"><a class="nav-link" href="{{ route('nasabah.dashboard') }}">Buku Saku</a></li>
                    @elseif (auth()->user()->role === 'kelurahan')
                    <li class="nav-item"><a class="nav-link" href="{{ route('kelurahan.dashboard') }}">Dashboard</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profil</a></li>
                </ul>

                <form method="POST" action="{{ route('logout') }}" class="mt-2 mt-md-0">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout ({{ auth()->user()->name }})</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="text-center text-muted small py-4 mt-5 no-print">
        &copy; {{ now()->year }} SIMBAH — Sistem Informasi & Manajemen Bank Sampah Terpadu
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>