@extends('layouts.member')
@section('title', 'Arsip Kostum — Art-Hub')
@section('page-title', 'Arsip Kostum & Properti')

@section('content')
{{-- Filter --}}
<div class="glass-card p-3 mb-4 animate-fade-up delay-1">
    <form action="{{ route('member.arsip-kostum') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="cari" class="form-control" placeholder="🔍 Cari kostum..." value="{{ request('cari') }}">
        </div>
        <div class="col-md-4">
            <select name="kategori" class="form-select">
                <option value="">Semua Kategori</option>
                <option value="tari" {{ request('kategori') == 'tari' ? 'selected' : '' }}>🎭 Tari</option>
                <option value="musik" {{ request('kategori') == 'musik' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="teater" {{ request('kategori') == 'teater' ? 'selected' : '' }}>🎬 Teater</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-burgundy w-100"><i class="bi bi-search me-1"></i> Filter</button>
        </div>
    </form>
</div>

{{-- Grid Kostum --}}
<div class="row g-4">
    @forelse($kostum as $k)
    <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ ($loop->index % 3) + 1 }}">
        <div class="glass-card h-100 overflow-hidden">
            @if($k->foto_path)
            <img src="{{ asset($k->foto_path) }}" class="w-100" style="height:180px;object-fit:cover;" alt="{{ $k->nama_kostum }}">
            @else
            <div class="w-100 d-flex align-items-center justify-content-center" style="height:180px;background:linear-gradient(135deg,#2980B9,#1A5276);">
                <i class="bi bi-palette text-white" style="font-size:3rem;opacity:0.5;"></i>
            </div>
            @endif
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold mb-0" style="color:var(--burgundy-700);">{{ $k->nama_kostum }}</h6>
                    <span class="badge bg-secondary">{{ ucfirst($k->kategori) }}</span>
                </div>
                <p class="text-muted small mb-2">{{ Str::limit($k->deskripsi, 80) }}</p>

                @if($k->nama_aksesoris)
                <div class="mb-2">
                    <small class="fw-semibold text-muted"><i class="bi bi-gem me-1"></i>Aksesoris:</small>
                    <small class="text-muted">{{ $k->nama_aksesoris }}</small>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <small>{{ $k->labelKondisi() }}</small>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailKostum{{ $k->id }}">
                        <i class="bi bi-eye me-1"></i>Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal fade" id="detailKostum{{ $k->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:var(--burgundy-700);">{{ $k->nama_kostum }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        @if($k->foto_path)
                        <div class="col-md-5">
                            <img src="{{ asset($k->foto_path) }}" class="w-100 rounded" alt="{{ $k->nama_kostum }}">
                        </div>
                        @endif
                        <div class="{{ $k->foto_path ? 'col-md-7' : 'col-12' }}">
                            <p>{{ $k->deskripsi }}</p>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" style="width:35%">Kategori</td>
                                    <td>{{ ucfirst($k->kategori) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Aksesoris</td>
                                    <td>{{ $k->nama_aksesoris ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kondisi Fisik</td>
                                    <td>{{ $k->labelKondisi() }}</td>
                                </tr>
                            </table>

                            @if($k->makna_warna)
                            <h6 class="fw-bold mt-3" style="color:var(--burgundy-700);"><i class="bi bi-droplet me-1"></i>Makna Warna</h6>
                            <p class="small">{{ $k->makna_warna }}</p>
                            @endif

                            @if($k->makna_ornamen)
                            <h6 class="fw-bold" style="color:var(--burgundy-700);"><i class="bi bi-flower2 me-1"></i>Makna Ornamen</h6>
                            <p class="small mb-0">{{ $k->makna_ornamen }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="glass-card p-5 text-center">
            <i class="bi bi-palette text-muted" style="font-size:3rem;"></i>
            <p class="text-muted mt-2">Belum ada kostum yang terdaftar.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $kostum->withQueryString()->links() }}</div>
@endsection