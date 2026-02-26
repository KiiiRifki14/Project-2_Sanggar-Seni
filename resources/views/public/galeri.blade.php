@extends('layouts.app')
@section('title', 'Galeri Pementasan — Art-Hub')

@section('content')
<section class="py-5" style="background:linear-gradient(135deg, var(--burgundy-900), var(--burgundy-700));color:white;">
    <div class="container text-center py-3">
        <h1 style="font-family:var(--font-heading);font-weight:700;">Galeri Pementasan</h1>
        <p class="text-white-50 mt-2">Dokumentasi foto & video pementasan terbaik Art-Hub</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($galeri->count() > 0)
        <div class="row g-4">
            @foreach($galeri as $g)
            <div class="col-6 col-md-4 col-lg-3 animate-fade-up delay-{{ ($loop->iteration % 5) + 1 }}">
                <div class="gallery-item">
                    @if($g->tipe === 'foto')
                    <img src="{{ asset($g->file_path) }}" alt="{{ $g->judul }}" loading="lazy">
                    @else
                    <div style="width:100%;height:220px;background:var(--dark-900);display:flex;align-items:center;justify-content:center;position:relative;">
                        <i class="bi bi-play-circle-fill text-white" style="font-size:3rem;opacity:0.8;"></i>
                    </div>
                    @endif
                    <div class="gallery-overlay">
                        <small class="fw-bold">{{ $g->judul }}</small>
                        @if($g->deskripsi)
                        <br><small class="opacity-75">{{ Str::limit($g->deskripsi, 50) }}</small>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">
            {{ $galeri->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-images" style="font-size:4rem;color:var(--cream-300);"></i>
            <h5 class="mt-3 text-muted">Belum ada konten galeri.</h5>
            <p class="text-muted small">Galeri akan diperbarui setelah admin mengunggah foto/video terbaru.</p>
        </div>
        @endif
    </div>
</section>
@endsection