@extends('layouts.admin')
@section('title', 'Dashboard Manajer — Art-Hub 2.0')
@section('page-title', 'Dashboard Manajer')

@section('content')
{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">📅</div>
            <h3 class="mb-0">{{ $totalEvent }}</h3>
            <small class="text-muted">Total Event</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">🔵</div>
            <h3 class="mb-0">{{ $eventAktif }}</h3>
            <small class="text-muted">Event Aktif</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">👥</div>
            <h3 class="mb-0">{{ $totalPersonel }}</h3>
            <small class="text-muted">Personel Aktif</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">💰</div>
            <h3 class="mb-0">Rp {{ number_format($totalLaba, 0, ',', '.') }}</h3>
            <small class="text-muted">Total Laba Bersih</small>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Upcoming Events --}}
    <div class="col-lg-6">
        <div class="card card-arthub">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-calendar-event me-1"></i> Event Mendatang</h6>
                @forelse($upcomingEvents as $ev)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $ev->nama_event }}</strong>
                        <br><small class="text-muted">{{ $ev->tanggal_event->translatedFormat('d M Y') }} • {{ $ev->klien }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $ev->status === 'persiapan' ? 'warning' : 'primary' }}">
                            {{ ucfirst($ev->status) }}
                        </span>
                        <br><small>{!! $ev->labelBayar() !!}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted mb-0">Belum ada event mendatang.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    <div class="col-lg-6">
        {{-- Merge Point Alerts --}}
        @if($mergePoints->isNotEmpty())
        <div class="card card-arthub border-warning mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-warning"><i class="bi bi-exclamation-triangle me-1"></i> Latihan Gabung Mendatang</h6>
                @foreach($mergePoints as $mp)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>🤝 {{ $mp->judul }}</strong>
                        <br><small class="text-muted">{{ $mp->event->nama_event }}</small>
                    </div>
                    <span class="badge bg-warning text-dark">{{ $mp->tanggal->translatedFormat('d M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Costume Return Deadlines --}}
        @if($deadlineKostum->isNotEmpty())
        <div class="card card-arthub border-danger">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-alarm me-1"></i> Deadline Pengembalian Kostum</h6>
                @foreach($deadlineKostum as $dk)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $dk->nama_kostum }}</strong>
                        <br><small class="text-muted">{{ $dk->vendor->nama_vendor }} • {{ $dk->event->nama_event }}</small>
                    </div>
                    <span class="badge bg-danger">{{ $dk->tanggal_kembali->translatedFormat('d M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($mergePoints->isEmpty() && $deadlineKostum->isEmpty())
        <div class="card card-arthub">
            <div class="card-body text-center py-4">
                <i class="bi bi-check-circle fs-1 text-success"></i>
                <p class="mt-2 mb-0 text-muted">Tidak ada notifikasi mendesak saat ini.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection