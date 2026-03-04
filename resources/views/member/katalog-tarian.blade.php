@extends('layouts.member')
@section('title', 'Katalog Tarian — Art-Hub')
@section('page-title', 'E-Encyclopedia — Katalog Tarian')

@section('content')
{{-- Filter --}}
<div class="glass-card p-3 mb-4 animate-fade-up delay-1">
    <form action="{{ route('member.katalog-tarian') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="cari" class="form-control" placeholder="🔍 Cari tarian..." value="{{ request('cari') }}">
        </div>
        <div class="col-md-3">
            <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                <option value="tari" {{ request('kategori') == 'tari' ? 'selected' : '' }}>🎭 Tari</option>
                <option value="musik" {{ request('kategori') == 'musik' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="teater" {{ request('kategori') == 'teater' ? 'selected' : '' }}>🎬 Teater</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="kesulitan" class="form-select">
                <option value="">Semua Tingkat</option>
                <option value="mudah" {{ request('kesulitan') == 'mudah' ? 'selected' : '' }}>🟢 Mudah</option>
                <option value="menengah" {{ request('kesulitan') == 'menengah' ? 'selected' : '' }}>🟡 Menengah</option>
                <option value="sulit" {{ request('kesulitan') == 'sulit' ? 'selected' : '' }}>🔴 Sulit</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-burgundy w-100"><i class="bi bi-search me-1"></i> Filter</button>
        </div>
    </form>
</div>

{{-- Grid Tarian --}}
<div class="row g-4">
    @forelse($tarian as $t)
    <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ ($loop->index % 3) + 1 }}">
        <div class="glass-card h-100 overflow-hidden">
            @if($t->foto_path)
            <img src="{{ asset($t->foto_path) }}" class="w-100" style="height:180px;object-fit:cover;" alt="{{ $t->nama_tarian }}">
            @else
            <div class="w-100 d-flex align-items-center justify-content-center" style="height:180px;background:linear-gradient(135deg,var(--burgundy-500),var(--burgundy-700));">
                <i class="bi bi-book text-white" style="font-size:3rem;opacity:0.5;"></i>
            </div>
            @endif
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold mb-0" style="color:var(--burgundy-700);">{{ $t->nama_tarian }}</h6>
                    <span class="badge bg-secondary">{{ ucfirst($t->kategori) }}</span>
                </div>
                <p class="text-muted small mb-2">{{ Str::limit($t->deskripsi, 100) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small>{{ $t->labelKesulitan() }}</small>
                    <a href="{{ route('member.detail-tarian', $t->id) }}" class="btn btn-sm btn-burgundy">
                        <i class="bi bi-eye me-1"></i>Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="glass-card p-5 text-center">
            <i class="bi bi-book text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-2">Belum ada tarian yang terdaftar.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $tarian->withQueryString()->links() }}</div>
@endsection