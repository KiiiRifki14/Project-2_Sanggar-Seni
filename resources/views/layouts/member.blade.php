<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Dashboard — Art-Hub')</title>
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
            <small>Portal Pelanggan</small>
        </div>
        <div class="sidebar-section-label">Menu Utama</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('member.dashboard') }}" class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="{{ route('member.profil') }}" class="{{ request()->routeIs('member.profil') ? 'active' : '' }}"><i class="bi bi-person"></i> Akun Saya</a></li>
        </ul>
        <div class="sidebar-section-label">Layanan</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('member.daftar-les') }}" class="{{ request()->routeIs('member.daftar-les') ? 'active' : '' }}"><i class="bi bi-pencil-square"></i> Daftar Les</a></li>
            <li><a href="{{ route('member.booking') }}" class="{{ request()->routeIs('member.booking') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Sewa Panggung</a></li>
            <li><a href="{{ route('member.riwayat') }}" class="{{ request()->routeIs('member.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat</a></li>
        </ul>
        <div class="sidebar-section-label">Lainnya</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('landing') }}"><i class="bi bi-globe"></i> Lihat Website</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none;border:none;width:100%;text-align:left;" class="d-flex align-items-center gap-2" style="padding:0.75rem 1.5rem;color:rgba(255,255,255,0.7);font-weight:500;font-size:0.92rem;">
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
            @if(session('wa_link'))
            <div class="alert alert-arthub alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-whatsapp"></i>
                <a href="{{ session('wa_link') }}" target="_blank" class="fw-bold text-success text-decoration-underline">Klik di sini untuk kirim pesan WhatsApp ke Admin</a>
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