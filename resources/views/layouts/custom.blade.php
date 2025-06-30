<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QC-Cinema XXI</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@800&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #f3f9f9, #eef6f7);
            font-family: 'segoe UI', sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background-color: #0b0c10 !important;
        }

        .navbar-brand img {
            height: 30px;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #00d1b2 !important;
        }

        .dropdown-menu {
            background-color: #0b0c10;
            border-radius: 0.5rem;
            border: none;
        }

        .dropdown-menu .dropdown-item:hover {
            color: #00d1b2 !important;
            background-color: transparent;
        }

        main {
            padding-top: 90px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 4px 2px 2px rgba(0, 0, 0, 0.2);
        }

        footer {
            background-color: #0b0c10;
            color: #bbb;
        }

        footer a {
            color: #00d1b2;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Hilangkan efek blok pada hover untuk nav-link */
        .navbar-nav .nav-link,
        .navbar-nav .dropdown-item {
            color: #fff;
            padding-left: 0.4rem;
            padding-right: 0.4rem;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: transparent !important;
            color: #00d1b2 !important;
            /* Warna hijau toska modern */
            text-decoration: none;
        }

        .dropdown-menu .dropdown-item.active {
            background-color: transparent !important;
            color: #00d1b2 !important;
            font-weight: bold;
            text-shadow: 0 0 0 rgba(0, 209, 178, 0.3);
        }

        @media (max-width: 576px) {
            .dropdown-menu {
                right: 10px !important;
                left: auto !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen d-flex flex-column">
    @php use Illuminate\Support\Facades\Auth; @endphp

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container-fluid px-4 py-2">
            <a class="navbar-brand d-flex align-items-center" href="https://cinema21.co.id" target="_blank">
                <img src="{{ asset('assets/images/cinemaxxi.png') }}" alt="Logo" height="27"
                    class="d-inline-block align-text-top me-3">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-house me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="meteranDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-folder-symlink me-1"></i> Data Meteran
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('meteran.input') ? 'active' : '' }}"
                                    href="{{ route('meteran.input') }}">Input Data Meteran</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}"
                                    href="{{ route('laporan.index') }}">Rekap Data Meteran</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Grafik Pemakaian</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="dcpDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-folder-symlink me-1"></i> DCP & Onesheet
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('dcp.form') ? 'active' : '' }}"
                                    href="{{ route('dcp.form') }}">Penerimaan DCP</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('onesheet.form') ? 'active' : '' }}"
                                    href="{{ route('onesheet.form') }}">Penerimaan Onesheet/Poster</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('dcp.laporan') ? 'active' : '' }}"
                                    href="{{ route('dcp.laporan') }}">Laporan DCP</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('onesheet.laporan') ? 'active' : '' }}"
                                    href="{{ route('onesheet.laporan') }}">Laporan Onesheet/Poster</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-white" id="maintenanceDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-tools me-1"></i> Maintenance
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('maintenance.projector.form') }}"
                                    class="dropdown-item {{ request()->routeIs('maintenance.projector.form') ? 'active' : '' }}">
                                    Projector & Sound Sytem
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('maintenance.hvac.form') }}"
                                    class="dropdown-item {{ request()->routeIs('maintenance.hvac.form') ? 'active' : '' }}">
                                    HVAC
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('maintenance.projector.laporan') }}">Laporan
                                    Projector</a></li>
                            <li><a class="dropdown-item" href="{{ route('maintenance.hvac.laporan') }}">Laporan
                                    HVAC</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="profileDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-lines-fill me-1"></i> Profil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('password.admin.change') ? 'active' : '' }}"
                                    href="{{ route('password.admin.change') }}">
                                    Ubah Password
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow container-fluid py-5 px-4 mt-5">
        @yield('content')
    </main>

    <footer class="text-center py-4">
        &copy; {{ date('Y') }}
        <a href="https://sobadanu.com" target="_blank">
            Soba Danu | Web Developer
        </a>. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
