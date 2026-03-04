@extends('layouts.member')
@section('title', 'Arsip Dokumentasi — Art-Hub')
@section('page-title', 'Log Preservasi — Arsip Dokumentasi')

@section('content')
{{-- Filter --}}
<div class="glass-card p-3 mb-4 animate-fade-up delay-1">
    <form action="{{ route('member.arsip-dokumentasi') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <select name="jenis" class="form-select">
                <option value="">Semua Jenis Acara</option>
                <option value="upacara_adat" {{ request('jenis') == 'upacara_adat' ? 'selected' : '' }}>🏛️ Upacara Adat</option>
                <option value="festival" {{ request('jenis') == 'festival' ? 'selected' : '' }}>🎪 Festival</option>
                <option value="penyambutan_tamu" {{ request('jenis') == 'penyambutan_tamu' ? 'selected' : '' }}>🤝 Penyambutan Tamu</option>
                <option value="lainnya" {{ request('jenis') == 'lainnya' ? 'selected' : '' }}>📁 Lainnya</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="tahun" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $thn)
                <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-burgundy w-100"><i class="bi bi-search me-1"></i> Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('member.arsip-dokumentasi') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>
</div>

{{-- Grid Dokumentasi --}}
<div class="row g-4">
    @forelse($dokumentasi as $d)
    <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ ($loop->index % 3) + 1 }}">
        <div class="glass-card h-100 overflow-hidden">
            <div class="w-100 d-flex align-items-center justify-content-center position-relative" style="height:160px;background:linear-gradient(135deg,#2C3E50,#34495E);">
                @if($d->tipe === 'video')
                <i class="bi bi-play-circle-fill text-white" style="font-size:3rem;opacity:0.7;"></i>
                @else
                <i class="bi bi-image text-white" style="font-size:3rem;opacity:0.7;"></i>
                @endif
                <div class="position-absolute top-0 end-0 m-2">
                    @if($d->tipe === 'video')
                    <span class="badge bg-danger"><i class="bi bi-play-circle me-1"></i>Video</span>
                    @else
                    <span class="badge bg-success"><i class="bi bi-image me-1"></i>Foto</span>
                    @endif
                </div>
            </div>
            <div class="p-3">
                <h6 class="fw-bold mb-1" style="color:var(--burgundy-700);">{{ $d->judul }}</h6>
                <div class="d-flex gap-2 mb-2">
                    <span class="badge bg-info text-dark">{{ $d->labelJenisAcara() }}</span>
                    <span class="badge bg-light text-dark">{{ $d->tahun }}</span>
                </div>
                <p class="text-muted small mb-0">{{ Str::limit($d->deskripsi, 100) }}</p>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="glass-card p-5 text-center">
            <i class="bi bi-camera-video text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-2">Belum ada dokumentasi.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $dokumentasi->withQueryString()->links() }}</div>
@endsection