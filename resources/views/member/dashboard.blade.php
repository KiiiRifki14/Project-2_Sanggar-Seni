@extends('layouts.member')
@section('title', 'Dashboard — Art-Hub Member')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4 animate-fade-up delay-1">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg, #FDECEA, #F8D7DA);color:#C0392B;">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="stat-number">{{ $totalLes }}</div>
            <div class="stat-label">Pendaftaran Les</div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-up delay-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg, #EBF5FB, #D6EAF8);color:#2980B9;">
                <i class="bi bi-calendar-event"></i>
            </div>
            <div class="stat-number">{{ $totalBooking }}</div>
            <div class="stat-label">Pesanan Pementasan</div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-up delay-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg, #D4EDDA, #C3E6CB);color:#155724;">
                <i class="bi bi-person-check"></i>
            </div>
            <div class="stat-number">{{ $user->name }}</div>
            <div class="stat-label">Selamat Datang!</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Quick Actions --}}
    <div class="col-lg-6 animate-fade-up delay-2">
        <div class="glass-card p-4">
            <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('member.daftar-les') }}" class="btn btn-burgundy"><i class="bi bi-pencil-square me-2"></i> Daftar Les Baru</a>
                <a href="{{ route('member.booking') }}" class="btn btn-gold"><i class="bi bi-calendar-plus me-2"></i> Sewa Panggung / Booking</a>
                <a href="{{ route('member.profil') }}" class="btn btn-outline-secondary"><i class="bi bi-person-gear me-2"></i> Edit Profil</a>
            </div>
        </div>
    </div>

    {{-- Riwayat Les Terakhir --}}
    <div class="col-lg-6 animate-fade-up delay-3">
        <div class="glass-card p-4">
            <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-clock-history me-2"></i>Aktivitas Terakhir</h6>
            @if($lesTerakhir->count() > 0)
            @foreach($lesTerakhir as $les)
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <strong class="d-block small">{{ $les->kelas->nama_kelas }}</strong>
                    <small class="text-muted">{{ $les->created_at->diffForHumans() }}</small>
                </div>
                <span class="badge-{{ $les->status }}">{{ ucfirst($les->status) }}</span>
            </div>
            @endforeach
            @else
            <p class="text-muted small mb-0">Belum ada aktivitas.</p>
            @endif

            @if($bookingTerakhir->count() > 0)
            <h6 class="fw-bold mt-3 mb-2" style="font-size:0.85rem;color:var(--burgundy-700);">Booking:</h6>
            @foreach($bookingTerakhir as $bk)
            <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                <div>
                    <strong class="d-block small">{{ ucfirst($bk->jenis_acara) }} — {{ $bk->tanggal_pentas->format('d M Y') }}</strong>
                    <small class="text-muted">{{ $bk->lokasi_acara }}</small>
                </div>
                <span class="badge-{{ $bk->status }}">{{ ucfirst($bk->status) }}</span>
            </div>
            @endforeach
            @endif
            <a href="{{ route('member.riwayat') }}" class="btn btn-sm btn-outline-secondary mt-2 w-100">Lihat Semua Riwayat</a>
        </div>
    </div>
</div>
@endsection