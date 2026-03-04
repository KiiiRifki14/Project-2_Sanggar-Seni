@extends('layouts.app')
@section('title', 'Art-Hub — Sanggar Seni Tradisional')

@section('content')
{{-- ══ HERO ══ --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7 animate-fade-up">
                <span class="hero-badge">🎭 Sanggar Seni Terbaik</span>
                <h1 class="hero-title">Lestarikan Budaya,<br>Arsipkan Warisan Seni</h1>
                <p class="hero-subtitle">
                    Art-Hub adalah repositori digital seni budaya tradisional. Jelajahi ensiklopedia tarian, arsip kostum bersejarah, dan dokumentasi pementasan dari masa ke masa.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('katalog') }}" class="btn-gold">
                        <i class="bi bi-book"></i> Jelajahi Katalog
                    </a>
                    <a href="{{ route('register') }}" class="btn-outline-gold">
                        <i class="bi bi-person-plus"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-5 mt-lg-0 animate-fade-up delay-3">
                <div style="font-size:10rem;filter:drop-shadow(0 10px 30px rgba(0,0,0,0.3));animation:float 4s ease-in-out infinite;">
                    🎭
                </div>
                <p class="text-white-50 mt-2 fst-italic">"Seni adalah jiwa bangsa"</p>
            </div>
        </div>
    </div>
</section>

{{-- ══ TENTANG KAMI ══ --}}
<section class="py-5" style="background: white;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="p-4 rounded-4" style="background: linear-gradient(135deg, var(--cream-100), var(--cream-200)); border-left: 5px solid var(--gold-500);">
                    <h6 class="text-uppercase fw-bold" style="color:var(--gold-600);letter-spacing:2px;font-size:0.8rem;">Tentang Kami</h6>
                    <h2 class="section-title mt-2">Sanggar Seni Art-Hub</h2>
                    <p class="text-muted mt-3">
                        Berdiri sejak tahun 2010, Art-Hub telah berkomitmen melestarikan seni budaya tradisional Nusantara. Dengan pengajar berpengalaman dan kurikulum terstruktur, kami membimbing generasi muda untuk mencintai dan menguasai seni tari, musik, serta teater.
                    </p>
                    <div class="row mt-4">
                        <div class="col-4 text-center">
                            <h3 class="fw-bold" style="color:var(--burgundy-700);">14+</h3>
                            <small class="text-muted">Tahun Berdiri</small>
                        </div>
                        <div class="col-4 text-center">
                            <h3 class="fw-bold" style="color:var(--burgundy-700);">500+</h3>
                            <small class="text-muted">Alumni Siswa</small>
                        </div>
                        <div class="col-4 text-center">
                            <h3 class="fw-bold" style="color:var(--burgundy-700);">200+</h3>
                            <small class="text-muted">Pementasan</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg, var(--burgundy-700), var(--burgundy-600));color:white;">
                            <i class="bi bi-music-note-beamed fs-1 d-block mb-2" style="color:var(--gold-400);"></i>
                            <h6 class="mb-0">Musik Tradisional</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg, var(--gold-500), var(--gold-400));color:var(--burgundy-900);">
                            <i class="bi bi-person-arms-up fs-1 d-block mb-2"></i>
                            <h6 class="mb-0">Tari Tradisional</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg, var(--gold-500), var(--gold-400));color:var(--burgundy-900);">
                            <i class="bi bi-mask fs-1 d-block mb-2"></i>
                            <h6 class="mb-0">Teater & Drama</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg, var(--burgundy-700), var(--burgundy-600));color:white;">
                            <i class="bi bi-stars fs-1 d-block mb-2" style="color:var(--gold-400);"></i>
                            <h6 class="mb-0">Jasa Pementasan</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ LAYANAN ══ --}}
<section class="py-5">
    <div class="container py-4">
        <div class="text-center">
            <h2 class="section-title">Repositori Digital</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Eksplorasi kekayaan budaya Nusantara secara digital</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate-fade-up delay-1">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-book"></i></div>
                    <h5 class="fw-bold mb-3">Katalog Tarian</h5>
                    <p class="text-muted small">Ensiklopedia lengkap tarian tradisional lengkap dengan sejarah, filosofi gerakan, dan video referensi.</p>
                    <a href="{{ route('katalog') }}" class="btn btn-sm btn-burgundy mt-2">Jelajahi <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 animate-fade-up delay-2">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-palette"></i></div>
                    <h5 class="fw-bold mb-3">Arsip Kostum</h5>
                    <p class="text-muted small">Katalog detail kostum dan alat musik tradisional. Makna warna, ornamen, dan kondisi fisik terdata lengkap.</p>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-burgundy mt-2">Lihat Arsip <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-4 animate-fade-up delay-3">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-camera-video"></i></div>
                    <h5 class="fw-bold mb-3">Dokumentasi</h5>
                    <p class="text-muted small">Arsip video dan foto pementasan masa lalu. Dikelompokkan berdasarkan jenis acara dan tahun.</p>
                    <a href="{{ route('galeri') }}" class="btn btn-sm btn-burgundy mt-2">Lihat Galeri <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ KELAS PREVIEW ══ --}}
@if($tarian->count() > 0)
<section class="py-5" style="background: linear-gradient(135deg, var(--burgundy-900), var(--burgundy-700));">
    <div class="container py-4">
        <div class="text-center text-white">
            <h2 style="font-family:var(--font-heading);font-weight:700;">Koleksi Tarian Kami</h2>
            <div class="section-divider" style="background:linear-gradient(90deg, var(--gold-400), var(--gold-300));"></div>
            <p style="color:rgba(255,255,255,0.7);">Jelajahi kekayaan seni tradisional yang telah kami arsipkan</p>
        </div>
        <div class="row g-4 mt-2">
            @foreach($tarian as $t)
            <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ $loop->iteration }}">
                <div class="kelas-card">
                    <div class="kelas-header">
                        <span class="kelas-badge {{ $t->kategori }}">{{ ucfirst($t->kategori) }}</span>
                        <h5 class="mt-2 mb-0 fw-bold">{{ $t->nama_tarian }}</h5>
                    </div>
                    <div class="kelas-body">
                        <p class="text-muted small flex-grow-1">{{ Str::limit($t->deskripsi, 100) }}</p>
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <span class="badge bg-secondary">{{ $t->labelKesulitan() }}</span>
                            @if($t->link_video_referensi)
                            <a href="{{ $t->link_video_referensi }}" target="_blank" class="btn btn-sm btn-outline-light"><i class="bi bi-play-circle me-1"></i>Video</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('katalog') }}" class="btn-gold"><i class="bi bi-grid"></i> Lihat Semua Koleksi</a>
        </div>
    </div>
</section>
@endif

{{-- ══ GALERI PREVIEW ══ --}}
@if($galeri->count() > 0)
<section class="py-5">
    <div class="container py-4">
        <div class="text-center">
            <h2 class="section-title">Galeri Pementasan</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Dokumentasi terbaik karya seni kami</p>
        </div>
        <div class="row g-3">
            @foreach($galeri->take(8) as $g)
            <div class="col-6 col-md-3 animate-fade-up delay-{{ $loop->iteration }}">
                <div class="gallery-item">
                    @if($g->tipe === 'foto')
                    <img src="{{ asset($g->file_path) }}" alt="{{ $g->judul }}">
                    @else
                    <div style="width:100%;height:220px;background:var(--dark-900);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-play-circle text-white" style="font-size:3rem;"></i>
                    </div>
                    @endif
                    <div class="gallery-overlay">
                        <small class="fw-bold">{{ $g->judul }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('galeri') }}" class="btn-burgundy"><i class="bi bi-images"></i> Lihat Semua Galeri</a>
        </div>
    </div>
</section>
@endif

{{-- ══ TESTIMONI ══ --}}
<section class="py-5" style="background:white;">
    <div class="container py-4">
        <div class="text-center">
            <h2 class="section-title">Apa Kata Mereka</h2>
            <div class="section-divider"></div>
            <p class="section-subtitle">Testimoni dari klien dan orang tua murid</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate-fade-up delay-1">
                <div class="testimoni-card">
                    <div class="quote-icon mb-2"><i class="bi bi-quote"></i></div>
                    <p class="text-muted">"Sanggar Art-Hub sangat profesional! Penampilan tari di acara pernikahan anak saya sangat memukau semua tamu undangan."</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;background:var(--burgundy-600);color:white;font-weight:bold;">HA</div>
                        <div>
                            <strong class="d-block" style="font-size:0.9rem;">Hj. Ani Sumarni</strong>
                            <small class="text-muted">Klien - Pernikahan</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 animate-fade-up delay-2">
                <div class="testimoni-card">
                    <div class="quote-icon mb-2"><i class="bi bi-quote"></i></div>
                    <p class="text-muted">"Anak saya jadi lebih percaya diri setelah belajar tari di sini. Guru-gurunya sabar dan metode pengajarannya menyenangkan."</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;background:var(--gold-500);color:var(--burgundy-900);font-weight:bold;">DS</div>
                        <div>
                            <strong class="d-block" style="font-size:0.9rem;">Dedi Suryadi</strong>
                            <small class="text-muted">Orang Tua Murid</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 animate-fade-up delay-3">
                <div class="testimoni-card">
                    <div class="quote-icon mb-2"><i class="bi bi-quote"></i></div>
                    <p class="text-muted">"Kolaborasi dengan Art-Hub di Festival Seni Budaya luar biasa. Tim sangat solid dan kreatif. Pasti kerja sama lagi!"</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:45px;height:45px;background:var(--burgundy-600);color:white;font-weight:bold;">RW</div>
                        <div>
                            <strong class="d-block" style="font-size:0.9rem;">Rizky Wibowo</strong>
                            <small class="text-muted">Event Organizer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ CTA ══ --}}
<section class="py-5" style="background: linear-gradient(135deg, var(--burgundy-800), var(--burgundy-600));">
    <div class="container text-center py-4">
        <h2 class="text-white" style="font-family:var(--font-heading);font-weight:700;font-size:2.2rem;">Siap Bergabung dengan Kami?</h2>
        <p class="text-white-50 mt-2 mb-4">Daftarkan diri Anda sekarang dan mulai perjalanan seni tradisional bersama Art-Hub!</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn-gold btn-lg"><i class="bi bi-person-plus"></i> Daftar Sekarang</a>
            <a href="https://wa.me/628123456789" target="_blank" class="btn-outline-gold btn-lg"><i class="bi bi-whatsapp"></i> Hubungi Kami</a>
        </div>
    </div>
</section>
@endsection