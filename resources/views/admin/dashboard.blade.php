@extends('layouts.admin')
@section('title', 'Admin Dashboard — Art-Hub')
@section('page-title', 'Dashboard Admin')

@section('content')
{{-- Stats Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg animate-fade-up delay-1">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#FFF3CD,#FFEEBA);color:#856404;">
                <i class="bi bi-clipboard-check"></i>
            </div>
            <div class="stat-number">{{ $pendaftaranBaru }}</div>
            <div class="stat-label">Pendaftar Les Baru</div>
        </div>
    </div>
    <div class="col-md-4 col-lg animate-fade-up delay-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#D6EAF8,#AED6F1);color:#2980B9;">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-number">{{ $bookingBaru }}</div>
            <div class="stat-label">Booking Menunggu</div>
        </div>
    </div>
    <div class="col-md-4 col-lg animate-fade-up delay-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#D4EDDA,#C3E6CB);color:#155724;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-number">{{ $totalSiswa }}</div>
            <div class="stat-label">Siswa Aktif</div>
        </div>
    </div>
    <div class="col-md-4 col-lg animate-fade-up delay-4">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#F8D7DA,#F5C6CB);color:#721C24;">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="stat-number">{{ $totalMember }}</div>
            <div class="stat-label">Total Member</div>
        </div>
    </div>
    <div class="col-md-4 col-lg animate-fade-up delay-5">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#E8DAEF,#D2B4DE);color:#6C3483;">
                <i class="bi bi-images"></i>
            </div>
            <div class="stat-number">{{ $totalGaleri }}</div>
            <div class="stat-label">Item Galeri</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Pendaftaran Menunggu --}}
    <div class="col-lg-6 animate-fade-up delay-2">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0" style="color:var(--burgundy-700);">
                    <i class="bi bi-clipboard-check me-2"></i>Pendaftaran Les Terbaru
                </h6>
                @if($pendaftaranBaru > 0)
                <span class="badge bg-warning text-dark rounded-pill">{{ $pendaftaranBaru }} baru</span>
                @endif
            </div>
            @forelse($pendaftaranTerbaru as $p)
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <strong class="d-block small">{{ $p->user->name }}</strong>
                    <small class="text-muted">{{ $p->kelas->nama_kelas }} &middot; {{ $p->created_at->diffForHumans() }}</small>
                </div>
                <span class="badge-menunggu">Menunggu</span>
            </div>
            @empty
            <p class="text-muted small mb-0">Tidak ada pendaftaran menunggu.</p>
            @endforelse
            <a href="{{ route('admin.validasi-les') }}" class="btn btn-sm btn-burgundy w-100 mt-2">Kelola Semua</a>
        </div>
    </div>

    {{-- Booking Menunggu --}}
    <div class="col-lg-6 animate-fade-up delay-3">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0" style="color:var(--burgundy-700);">
                    <i class="bi bi-calendar-event me-2"></i>Booking Pentas Terbaru
                </h6>
                @if($bookingBaru > 0)
                <span class="badge bg-info text-dark rounded-pill">{{ $bookingBaru }} baru</span>
                @endif
            </div>
            @forelse($bookingTerbaru as $b)
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <strong class="d-block small">{{ ucfirst($b->jenis_acara) }} — {{ $b->user->name }}</strong>
                    <small class="text-muted">{{ $b->tanggal_pentas->format('d M Y') }} &middot; {{ $b->lokasi_acara }}</small>
                </div>
                <span class="badge-menunggu">Menunggu</span>
            </div>
            @empty
            <p class="text-muted small mb-0">Tidak ada booking menunggu.</p>
            @endforelse
            <a href="{{ route('admin.validasi-booking') }}" class="btn btn-sm btn-gold w-100 mt-2">Kelola Semua</a>
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="row g-3 mt-3">
    <div class="col-md-3 animate-fade-up delay-3">
        <a href="{{ route('admin.galeri') }}" class="d-block glass-card p-3 text-center text-decoration-none" style="color:var(--burgundy-700);">
            <i class="bi bi-images fs-3 d-block mb-1" style="color:var(--gold-500);"></i>
            <small class="fw-bold">Kelola Galeri</small>
        </a>
    </div>
    <div class="col-md-3 animate-fade-up delay-4">
        <a href="{{ route('admin.siswa') }}" class="d-block glass-card p-3 text-center text-decoration-none" style="color:var(--burgundy-700);">
            <i class="bi bi-people fs-3 d-block mb-1" style="color:var(--gold-500);"></i>
            <small class="fw-bold">Data Siswa</small>
        </a>
    </div>
    <div class="col-md-3 animate-fade-up delay-5">
        <a href="{{ route('admin.jadwal') }}" class="d-block glass-card p-3 text-center text-decoration-none" style="color:var(--burgundy-700);">
            <i class="bi bi-calendar3 fs-3 d-block mb-1" style="color:var(--gold-500);"></i>
            <small class="fw-bold">Jadwal Pentas</small>
        </a>
    </div>
    <div class="col-md-3 animate-fade-up delay-5">
        <a href="{{ route('admin.laporan') }}" class="d-block glass-card p-3 text-center text-decoration-none" style="color:var(--burgundy-700);">
            <i class="bi bi-file-earmark-bar-graph fs-3 d-block mb-1" style="color:var(--gold-500);"></i>
            <small class="fw-bold">Laporan & Rekap</small>
        </a>
    </div>
</div>
@endsection