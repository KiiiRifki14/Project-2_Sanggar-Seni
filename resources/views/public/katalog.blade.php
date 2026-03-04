@extends('layouts.app')
@section('title', 'Katalog Tarian — Art-Hub')

@section('content')
<section class="py-5" style="background:linear-gradient(135deg, var(--burgundy-900), var(--burgundy-700));color:white;">
    <div class="container text-center py-3">
        <h1 style="font-family:var(--font-heading);font-weight:700;">Katalog Tarian & Seni</h1>
        <p class="text-white-50 mt-2">Jelajahi ensiklopedia seni tradisional yang telah kami arsipkan</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($tarian->count() > 0)
        <div class="row g-4">
            @foreach($tarian as $t)
            <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ ($loop->iteration % 5) + 1 }}">
                <div class="kelas-card">
                    <div class="kelas-header">
                        <span class="kelas-badge {{ $t->kategori }}">{{ ucfirst($t->kategori) }}</span>
                        <h5 class="mt-2 mb-0 fw-bold">{{ $t->nama_tarian }}</h5>
                    </div>
                    <div class="kelas-body">
                        <p class="text-muted small">{{ Str::limit($t->deskripsi, 120) }}</p>
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-bar-chart me-1"></i> <strong>Tingkat:</strong> {{ $t->labelKesulitan() }}</small>
                        </div>
                        @if($t->sejarah_singkat)
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-hourglass-split me-1"></i> <strong>Sejarah:</strong> {{ Str::limit($t->sejarah_singkat, 80) }}</small>
                        </div>
                        @endif
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            @if($t->link_video_referensi)
                            <a href="{{ $t->link_video_referensi }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-play-circle me-1"></i>Video</a>
                            @else
                            <span></span>
                            @endif
                            @auth
                            @if(auth()->user()->isMember())
                            <a href="{{ route('member.detail-tarian', $t->id) }}" class="btn btn-sm btn-gold">Detail</a>
                            @endif
                            @else
                            <a href="{{ route('register') }}" class="btn btn-sm btn-gold">Daftar & Lihat</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-book" style="font-size:4rem;color:var(--cream-300);"></i>
            <h5 class="mt-3 text-muted">Belum ada tarian yang terarsipkan.</h5>
        </div>
        @endif
    </div>
</section>
@endsection