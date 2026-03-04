@extends('layouts.member')
@section('title', $tarian->nama_tarian . ' — Art-Hub')
@section('page-title', 'Detail Tarian')

@section('content')
<div class="mb-3">
    <a href="{{ route('member.katalog-tarian') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog
    </a>
</div>

<div class="row g-4">
    {{-- Info Utama --}}
    <div class="col-lg-8 animate-fade-up delay-1">
        <div class="glass-card p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h4 class="fw-bold mb-1" style="color:var(--burgundy-700);">{{ $tarian->nama_tarian }}</h4>
                    <span class="badge bg-secondary me-1">{{ ucfirst($tarian->kategori) }}</span>
                    <span class="badge bg-light text-dark">{{ $tarian->labelKesulitan() }}</span>
                </div>
                @if($tarian->link_video_referensi)
                <a href="{{ $tarian->link_video_referensi }}" target="_blank" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-play-circle me-1"></i>Video
                </a>
                @endif
            </div>

            @if($tarian->foto_path)
            <img src="{{ asset($tarian->foto_path) }}" class="w-100 rounded mb-3" style="max-height:350px;object-fit:cover;" alt="{{ $tarian->nama_tarian }}">
            @endif

            <h6 class="fw-bold mt-3" style="color:var(--burgundy-700);"><i class="bi bi-info-circle me-2"></i>Deskripsi</h6>
            <p>{{ $tarian->deskripsi }}</p>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="col-lg-4 animate-fade-up delay-2">
        @if($tarian->filosofi_gerakan)
        <div class="glass-card p-4 mb-4">
            <h6 class="fw-bold" style="color:var(--burgundy-700);"><i class="bi bi-flower1 me-2"></i>Filosofi Gerakan</h6>
            <p class="small mb-0">{{ $tarian->filosofi_gerakan }}</p>
        </div>
        @endif

        @if($tarian->sejarah_singkat)
        <div class="glass-card p-4 mb-4">
            <h6 class="fw-bold" style="color:var(--burgundy-700);"><i class="bi bi-hourglass-split me-2"></i>Sejarah Singkat</h6>
            <p class="small mb-0">{{ $tarian->sejarah_singkat }}</p>
        </div>
        @endif

        <div class="glass-card p-4">
            <h6 class="fw-bold" style="color:var(--burgundy-700);"><i class="bi bi-card-list me-2"></i>Informasi</h6>
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="text-muted">Kategori</td>
                    <td class="fw-semibold">{{ ucfirst($tarian->kategori) }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Kesulitan</td>
                    <td class="fw-semibold">{{ $tarian->labelKesulitan() }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Ditambahkan</td>
                    <td class="fw-semibold">{{ $tarian->created_at->format('d M Y') }}</td>
                </tr>
                @if($tarian->link_video_referensi)
                <tr>
                    <td class="text-muted">Video</td>
                    <td><a href="{{ $tarian->link_video_referensi }}" target="_blank" class="text-decoration-none">Tonton <i class="bi bi-box-arrow-up-right"></i></a></td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection