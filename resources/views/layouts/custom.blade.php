<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QC-Cinema XXI</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #f3f9f9, #eef6f7);
        }

        .sidebar {
            height: 100vh;
            background-color: #333333;
            padding-top: 1rem;
            width: 250px;
            position: fixed;
            top: 60px;
            left: 0;
            overflow-y: auto;
            transform: translateX(0);
            transition: transform 0.3s ease;
            z-index: 1040;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #c9c9c9;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0.375rem;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .main-content.collapsed {
            margin-left: 70px;
        }

        #toggleSidebar:hover {
            background-color: #367fa9;
            /* kuning Bootstrap */
            transition: background-color 0.3s ease;
            border-radius: 0;
        }

        #toggleSidebar:hover #toggleIcon {
            color: #fff;
        }

        .topbar {
            height: 60px;
            background-color: #3c8dbc;
            padding-left: 0 !important;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .topbar .logo {
            width: 250px;
            /* Sesuaikan dengan sidebar */
            height: 100%;
            background-color: #367fa9;
            /* Warna sidebar */
            margin: 0;
            padding: 0;
        }

        .topbar .logo img {
            height: 38px;
        }

        .topbar .logo a {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 0;
        }

        .main-content {
            margin-left: 200px;
            padding: 4rem;
            transition: margin-left 0.3s ease;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #ffffff;
            color: #000000;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            box-shadow: 4px 2px 0px rgba(0, 0, 0, 0.1);
        }

        footer.collapsed {
            margin-left: 70px;
        }

        /* Tambahkan ini ke CSS kamu */
        .sidebar.slide-hidden {
            transform: translateX(-100%);
        }

        .main-content.full-width {
            margin-left: 0 !important;
        }

        footer.full-width {
            margin-left: 0 !important;
        }

        .hover-link:hover {
            color: #367fa9 !important;
            text-decoration: underline;
        }

        .hover-icon:hover {
            color: #367fa9 !important;
            transform: scale(1.2);
            transition: 0.3s ease;
        }

        .btn-hover-warning:hover {
            background-color: #d5a000 !important;
            /* Bootstrap warning color */
            color: #000 !important;
            /* Ubah warna teks biar terbaca */
            border-color: #d5a000 !important;
        }


        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1040;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .overlay {
                display: block;
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 1035;
            }

            .overlay.hidden {
                display: none;
            }

            .main-content,
            footer {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header / Navbar -->
    <div class="topbar shadow-sm">
        <!-- Logo -->
        <div class="logo">
            <a href="/" class="text-decoration-none">
                <img src="{{ asset('assets/images/cinemaxxi.png') }}" alt="Logo XXI" style="height: 32px;">
            </a>
        </div>

        <!-- Toggle Sidebar -->
        <button class="btn h-100 px-3 border-0 rounded-0" id="toggleSidebar">
            <i class="bi bi-list fs-3 text-white" id="toggleIcon"></i>
        </button>

        @php
            use Illuminate\Support\Facades\Auth;
            $user = Auth::guard('admin')->user();
        @endphp

        <!-- Nama Bioskop -->
        <div class="ms-auto me-4 fw-bold"
            style="font-size: 1.1rem; color: #ffffff; letter-spacing: 1px; font-family: 'Roboto Slab', sans-serif;">
            {{ $user->nama_bioskop ?? 'Dashboard' }}
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar show">
        <ul class="nav flex-column px-3">
            @if ($user && $user->role !== 'admin')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house"></i> Dashboard
                    </a>
                </li>

                <!-- Dropdown: Meteran -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle {{ request()->is('meteran*') || request()->is('laporan*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#meteranSub" role="button"
                        aria-expanded="{{ request()->is('meteran*') || request()->is('laporan*') ? 'true' : 'false' }}"
                        aria-controls="meteranSub">
                        <i class="bi bi-lightning-charge-fill"></i> Data Meteran
                    </a>
                    <div class="collapse {{ request()->is('meteran*') || request()->is('laporan*') ? 'show' : '' }}"
                        id="meteranSub">
                        <a href="{{ route('meteran.input') }}"
                            class="nav-link ps-4 {{ request()->routeIs('meteran.input') ? 'active' : '' }}">Form
                            Meteran</a>
                        <a href="{{ route('laporan.index') }}"
                            class="nav-link ps-4 {{ request()->routeIs('laporan.index') ? 'active' : '' }}">Laporan
                            Meteran</a>
                    </div>
                </li>

                <!-- Dropdown: DCP & Poster -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle {{ request()->is('dcp*') || request()->is('onesheet*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#dcpSub" role="button"
                        aria-expanded="{{ request()->is('dcp*') || request()->is('onesheet*') ? 'true' : 'false' }}"
                        aria-controls="dcpSub">
                        <i class="bi bi-film"></i> DCP & Onesheet
                    </a>
                    <div class="collapse {{ request()->is('dcp*') || request()->is('onesheet*') ? 'show' : '' }}"
                        id="dcpSub">
                        <a href="{{ route('dcp.form') }}"
                            class="nav-link ps-4 {{ request()->routeIs('dcp.form') ? 'active' : '' }}">Form DCP</a>
                        <a href="{{ route('onesheet.form') }}"
                            class="nav-link ps-4 {{ request()->routeIs('onesheet.form') ? 'active' : '' }}">Form
                            Poster</a>
                        <a href="{{ route('dcp.laporan') }}"
                            class="nav-link ps-4 {{ request()->routeIs('dcp.laporan') ? 'active' : '' }}">Laporan
                            DCP</a>
                        <a href="{{ route('onesheet.laporan') }}"
                            class="nav-link ps-4 {{ request()->routeIs('onesheet.laporan') ? 'active' : '' }}">Laporan
                            Poster</a>
                    </div>
                </li>

                <!-- Dropdown: Maintenance -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle {{ request()->is('maintenance*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#maintSub" role="button"
                        aria-expanded="{{ request()->is('maintenance*') ? 'true' : 'false' }}"
                        aria-controls="maintSub">
                        <i class="bi bi-tools"></i> Troubleshooting
                    </a>
                    <div class="collapse {{ request()->is('maintenance*') ? 'show' : '' }}" id="maintSub">
                        <a href="{{ route('maintenance.projector.form') }}"
                            class="nav-link ps-4 {{ request()->routeIs('maintenance.projector.form') ? 'active' : '' }}">Form
                            Projector</a>
                        <a href="{{ route('maintenance.hvac.form') }}"
                            class="nav-link ps-4 {{ request()->routeIs('maintenance.hvac.form') ? 'active' : '' }}">Form
                            HVAC</a>
                        <a href="{{ route('maintenance.projector.laporan') }}"
                            class="nav-link ps-4 {{ request()->routeIs('maintenance.projector.laporan') ? 'active' : '' }}">Laporan
                            Projector</a>
                        <a href="{{ route('maintenance.hvac.laporan') }}"
                            class="nav-link ps-4 {{ request()->routeIs('maintenance.hvac.laporan') ? 'active' : '' }}">Laporan
                            HVAC</a>
                    </div>
                </li>

                <!-- Profil -->
                <li class="nav-item">
                    <a href="{{ route('password.admin.change') }}"
                        class="nav-link {{ request()->routeIs('password.admin.change') ? 'active' : '' }}">
                        <i class="bi bi-person-lines-fill"></i> Profil
                    </a>
                </li>
            @endif

            @if ($user && $user->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.userdata') }}"
                        class="nav-link {{ request()->routeIs('admin.userdata') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Data User
                    </a>
                </li>
            @endif

            <!-- Logout -->
            <li class="nav-item mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light w-100 btn-hover-warning" type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow text-center">
        &copy; {{ date('Y') }}
        <a href="https://sobadanu.com" target="_blank" class="text-muted text-decoration-none fw-semibold hover-link">
            SobaDanu - Full Stack Developer
        </a>
        &nbsp;|&nbsp;
        <a href="https://github.com/sobadanuwahab" target="_blank" class="text-dark mx-1 hover-icon">
            <i class="bi bi-github fs-5"></i>
        </a>
        <a href="https://wa.me/6281314333352" target="_blank" class="text-dark mx-1 hover-icon">
            <i class="bi bi-whatsapp fs-5"></i>
        </a>
        <span class="d-block mt-1 small text-muted">All rights reserved.</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <!-- Overlay -->
    <div class="overlay hidden" id="sidebarOverlay"></div>

    <script>
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mainContent = document.querySelector('.main-content');
        const footer = document.querySelector('footer');

        toggleBtn.addEventListener('click', () => {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('hidden');
            } else {
                sidebar.classList.toggle('slide-hidden'); // pakai transform
                mainContent.classList.toggle('full-width');
                footer.classList.toggle('full-width');
            }
        });
    </script>

</body>

</html>
