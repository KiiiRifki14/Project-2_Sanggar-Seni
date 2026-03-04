@extends('layouts.app')
@section('title', 'Art-Hub 2.0 — Sistem Manajemen Sanggar Seni')

@section('content')
{{-- Hero Section --}}
<section class="py-5 text-center" style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);color:#fff;min-height:60vh;display:flex;align-items:center;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">🎭 Art-Hub 2.0</h1>
        <p class="lead mb-1" style="opacity:.85">Sistem Manajemen Operasional Sanggar Seni</p>
        <p class="mb-4" style="opacity:.65;max-width:600px;margin:0 auto;">
            Platform terpadu untuk penjadwalan multi-track, manajemen logistik kostum, negosiasi harga klien, dan kalkulator laba bersih otomatis.
        </p>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-2"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4"><i class="bi bi-person-plus me-1"></i> Register</a>
    </div>
</section>

{{-- Features --}}
<section class="py-5" style="background:#f8f9fa;">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Fitur Utama</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="fs-1 mb-3">📅</div>
                        <h5 class="fw-bold">Multi-Track Scheduling</h5>
                        <p class="text-muted">Jadwal paralel untuk penari dan pemusik dengan titik gabung (Merge Point) otomatis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="fs-1 mb-3">👗</div>
                        <h5 class="fw-bold">Logistik Sewa Kostum</h5>
                        <p class="text-muted">Tracking sewa kostum dari vendor eksternal: pemesanan, pengambilan, dan deadline pengembalian.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="fs-1 mb-3">💰</div>
                        <h5 class="fw-bold">Kalkulator Laba Otomatis</h5>
                        <p class="text-muted">Negosiasi harga klien, estimasi vs realisasi biaya, dan perhitungan laba bersih per event.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <h2 class="fw-bold text-primary">{{ $completedEvents }}</h2>
                <p class="text-muted">Event Selesai</p>
            </div>
            <div class="col-md-4">
                <h2 class="fw-bold text-primary">{{ $upcomingEvents->count() }}</h2>
                <p class="text-muted">Event Mendatang</p>
            </div>
            <div class="col-md-4">
                <h2 class="fw-bold text-primary">16+</h2>
                <p class="text-muted">Personel Aktif</p>
            </div>
        </div>
    </div>
</section>

{{-- Upcoming Events --}}
@if($upcomingEvents->isNotEmpty())
<section class="py-5" style="background:#f8f9fa;">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Event Mendatang</h2>
        <div class="row g-3 justify-content-center">
            @foreach($upcomingEvents as $ev)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $ev->nama_event }}</h6>
                        <p class="text-muted mb-1"><i class="bi bi-calendar me-1"></i> {{ $ev->tanggal_event->translatedFormat('d M Y') }}</p>
                        <p class="text-muted mb-0"><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($ev->lokasi, 40) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Footer --}}
<footer class="py-4 text-center" style="background:#1a1a2e;color:rgba(255,255,255,.6);">
    <div class="container">
        <p class="mb-0">&copy; {{ date('Y') }} Art-Hub 2.0 — Sistem Manajemen Sanggar Seni</p>
    </div>
</footer>
@endsection