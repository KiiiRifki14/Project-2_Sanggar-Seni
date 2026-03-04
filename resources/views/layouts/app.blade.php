<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Art-Hub 2.0 — Sistem Manajemen Operasional Sanggar Seni. Penjadwalan multi-track, logistik kostum, dan kalkulator laba otomatis.">
    <title>@yield('title', 'Art-Hub 2.0 — Sanggar Seni')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    {{-- ══ NAVBAR ══ --}}
    <nav class="navbar navbar-expand-lg navbar-arthub">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <span class="brand-icon">🎭</span> Art-Hub 2.0
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}">
                            <i class="bi bi-house-heart me-1"></i> Beranda
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    @auth
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-navbar">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Manajer
                    </a>
                    @else
                    <a href="{{ route('member.dashboard') }}" class="btn-navbar">
                        <i class="bi bi-person-circle me-1"></i> Portal Personel
                    </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light rounded-pill">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="nav-link text-white">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-navbar">
                        <i class="bi bi-person-plus me-1"></i> Daftar
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ══ ALERTS ══ --}}
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-arthub alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-arthub alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
    </div>

    {{-- ══ CONTENT ══ --}}
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>