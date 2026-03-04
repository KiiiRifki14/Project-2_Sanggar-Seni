@extends('layouts.member')
@section('title', 'Dashboard Personel — Art-Hub 2.0')
@section('page-title', 'Dashboard Personel')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">📅</div>
            <h3 class="mb-0">{{ $upcomingJadwals->count() }}</h3>
            <small class="text-muted">Jadwal Mendatang</small>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-arthub text-center p-3">
            <div class="fs-2 mb-1">🤝</div>
            <h3 class="mb-0">{{ $mergePointCount }}</h3>
            <small class="text-muted">Latihan Gabung Segera</small>
        </div>
    </div>
</div>

<div class="card card-arthub">
    <div class="card-body">
        <h6 class="fw-bold mb-3"><i class="bi bi-calendar-week me-1"></i> Jadwal Latihan Mendatang</h6>
        @forelse($upcomingJadwals as $j)
        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
            <div>
                <strong>{{ $j->judul }}</strong>
                @if($j->is_merge_point) <span class="badge bg-warning text-dark">🔗 Merge Point</span> @endif
                <br>
                <small class="text-muted">
                    {{ $j->event->nama_event }} •
                    {!! strip_tags($j->labelTrack()) !!}
                </small>
            </div>
            <div class="text-end">
                <span class="badge bg-dark">{{ $j->tanggal->translatedFormat('d M Y') }}</span>
                <br><small class="text-muted">⏰ {{ $j->waktu_mulai }}–{{ $j->waktu_selesai }}</small>
            </div>
        </div>
        @empty
        <p class="text-muted text-center py-3">Tidak ada jadwal mendatang.</p>
        @endforelse
    </div>
</div>
@endsection