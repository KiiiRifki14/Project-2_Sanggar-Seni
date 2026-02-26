<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard — Art-Hub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    {{-- ══ SIDEBAR ══ --}}
    <aside class="dashboard-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>🎭 Art-Hub</h4>
            <small>Admin Panel</small>
        </div>
        <div class="sidebar-section-label">Utama</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        </ul>
        <div class="sidebar-section-label">Validasi</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.validasi-les') }}" class="{{ request()->routeIs('admin.validasi-les') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Validasi Les</a></li>
            <li><a href="{{ route('admin.validasi-booking') }}" class="{{ request()->routeIs('admin.validasi-booking') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Validasi Booking</a></li>
        </ul>
        <div class="sidebar-section-label">Kelola</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.galeri') }}" class="{{ request()->routeIs('admin.galeri') ? 'active' : '' }}"><i class="bi bi-images"></i> Galeri</a></li>
            <li><a href="{{ route('admin.siswa') }}" class="{{ request()->routeIs('admin.siswa') ? 'active' : '' }}"><i class="bi bi-people"></i> Data Siswa</a></li>
            <li><a href="{{ route('admin.jadwal') }}" class="{{ request()->routeIs('admin.jadwal') ? 'active' : '' }}"><i class="bi bi-calendar3"></i> Jadwal Pentas</a></li>
        </ul>
        <div class="sidebar-section-label">Laporan</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan & Rekap</a></li>
        </ul>
        <div class="sidebar-section-label">Lainnya</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('landing') }}"><i class="bi bi-globe"></i> Lihat Website</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none;border:none;width:100%;text-align:left;" class="d-flex align-items-center gap-2" style="padding:0.75rem 1.5rem;color:rgba(255,255,255,0.7);">
                        <i class="bi bi-box-arrow-left" style="width:20px;text-align:center;font-size:1.1rem;"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    {{-- ══ MAIN CONTENT ══ --}}
    <div class="dashboard-content">
        <div class="dashboard-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5>@yield('page-title', 'Admin Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-danger rounded-pill" id="notif-badge" style="display:none;"></span>
                <span class="text-muted small"><i class="bi bi-shield-check me-1"></i> {{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="dashboard-body">
            @if(session('success'))
            <div class="alert alert-arthub alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-arthub alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>