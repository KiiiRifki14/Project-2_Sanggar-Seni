<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Personel — Art-Hub 2.0')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    {{-- ══ SIDEBAR ══ --}}
    <aside class="dashboard-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>🎭 Art-Hub 2.0</h4>
            <small>Portal Personel</small>
        </div>
        <div class="sidebar-section-label">Menu Utama</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('member.dashboard') }}" class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="{{ route('member.profil') }}" class="{{ request()->routeIs('member.profil') ? 'active' : '' }}"><i class="bi bi-person"></i> Akun Saya</a></li>
        </ul>
        <div class="sidebar-section-label">Jadwal & Kehadiran</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('member.jadwal') }}" class="{{ request()->routeIs('member.jadwal') ? 'active' : '' }}"><i class="bi bi-calendar-week"></i> Jadwal Latihan</a></li>
            <li><a href="{{ route('member.absensi') }}" class="{{ request()->routeIs('member.absensi') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Riwayat Absensi</a></li>
        </ul>
        <div class="sidebar-section-label">Lainnya</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('landing') }}"><i class="bi bi-globe"></i> Lihat Website</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none;border:none;width:100%;text-align:left;" class="d-flex align-items-center gap-2">
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
                <h5>@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-info rounded-pill">Personel</span>
                <span class="text-muted small"><i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}</span>
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