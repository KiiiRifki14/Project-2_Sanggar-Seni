<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajer Dashboard — Art-Hub 2.0')</title>
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
            <small>Manajer Panel</small>
        </div>
        <div class="sidebar-section-label">Utama</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        </ul>
        <div class="sidebar-section-label">Manajemen Event</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.kelola-event') }}" class="{{ request()->routeIs('admin.kelola-event') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Kelola Event</a></li>
            <li><a href="{{ route('admin.jadwal') }}" class="{{ request()->routeIs('admin.jadwal') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Jadwal Multi-Track</a></li>
            <li><a href="{{ route('admin.absensi') }}" class="{{ request()->routeIs('admin.absensi') ? 'active' : '' }}"><i class="bi bi-person-check"></i> Absensi Latihan</a></li>
        </ul>
        <div class="sidebar-section-label">Personel & Logistik</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.kelola-personel') }}" class="{{ request()->routeIs('admin.kelola-personel') ? 'active' : '' }}"><i class="bi bi-people"></i> Kelola Personel</a></li>
            <li><a href="{{ route('admin.kelola-vendor') }}" class="{{ request()->routeIs('admin.kelola-vendor') ? 'active' : '' }}"><i class="bi bi-shop"></i> Kelola Vendor</a></li>
            <li><a href="{{ route('admin.sewa-kostum') }}" class="{{ request()->routeIs('admin.sewa-kostum') ? 'active' : '' }}"><i class="bi bi-bag-check"></i> Sewa Kostum</a></li>
        </ul>
        <div class="sidebar-section-label">Keuangan</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.negosiasi') }}" class="{{ request()->routeIs('admin.negosiasi') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i> Negosiasi</a></li>
            <li><a href="{{ route('admin.keuangan') }}" class="{{ request()->routeIs('admin.keuangan') ? 'active' : '' }}"><i class="bi bi-calculator"></i> Kalkulator Laba</a></li>
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
                <h5>@yield('page-title', 'Dashboard Manajer')</h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success rounded-pill">Manajer</span>
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