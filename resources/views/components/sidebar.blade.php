{{-- Hidden 

<!-- components/sidebar-navbar.blade.php -->
@php
    $activityActive = request()->routeIs('meteran.*') || request()->routeIs('laporan.*');
    $dcpActive = request()->routeIs('dcp.*');
    $profileActive = request()->routeIs('password.admin.change');
@endphp

<li class="nav-item">
    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active fw-bold text-info' : '' }}" 
       href="{{ route('dashboard') }}">
        <i class="bi bi-house me-1"></i> Dashboard
    </a>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="navMeteran" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-folder-symlink me-1"></i> Data Meteran
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ request()->routeIs('meteran.input') ? 'active' : '' }}" href="{{ route('meteran.input') }}">Input Data</a></li>
        <li><a class="dropdown-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}">Rekap Data</a></li>
        <li><a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Grafik</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="navDCP" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-folder-symlink me-1"></i> DCP & Onesheet
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ request()->routeIs('dcp.form') ? 'active' : '' }}" href="{{ route('dcp.form') }}">Penerimaan DCP</a></li>
        <li><a class="dropdown-item {{ request()->routeIs('dcp.laporan') ? 'active' : '' }}" href="{{ route('dcp.laporan') }}">Laporan DCP</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="navProfile" role="button" data-bs-toggle="dropdown">
        <i class="bi bi-person-lines-fill me-1"></i> Profile
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ request()->routeIs('password.admin.change') ? 'active' : '' }}" href="{{ route('password.admin.change') }}">Ubah Password</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
            </form>
        </li>
    </ul>
</li>

}}