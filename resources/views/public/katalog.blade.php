@extends('layouts.app')
@section('title', 'Katalog Kelas & Tarif — Art-Hub')

@section('content')
<section class="py-5" style="background:linear-gradient(135deg, var(--burgundy-900), var(--burgundy-700));color:white;">
    <div class="container text-center py-3">
        <h1 style="font-family:var(--font-heading);font-weight:700;">Katalog Kelas & Tarif</h1>
        <p class="text-white-50 mt-2">Pilih kelas seni yang sesuai dengan minat dan bakat Anda</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($kelas->count() > 0)
        <div class="row g-4">
            @foreach($kelas as $k)
            <div class="col-md-6 col-lg-4 animate-fade-up delay-{{ ($loop->iteration % 5) + 1 }}">
                <div class="kelas-card">
                    <div class="kelas-header">
                        <span class="kelas-badge {{ $k->kategori }}">{{ ucfirst($k->kategori) }}</span>
                        <h5 class="mt-2 mb-0 fw-bold">{{ $k->nama_kelas }}</h5>
                    </div>
                    <div class="kelas-body">
                        <p class="text-muted small">{{ $k->deskripsi }}</p>
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i> <strong>Jadwal:</strong> {{ $k->jadwal }}</small>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block"><i class="bi bi-people me-1"></i> <strong>Kuota:</strong> {{ $k->kuota }} siswa</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div class="kelas-price">
                                Rp {{ number_format($k->biaya, 0, ',', '.') }} <small>/bulan</small>
                            </div>
                            @auth
                            @if(auth()->user()->isMember())
                            <a href="{{ route('member.daftar-les') }}" class="btn btn-sm btn-gold">Daftar</a>
                            @endif
                            @else
                            <a href="{{ route('register') }}" class="btn btn-sm btn-gold">Daftar</a>
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
            <h5 class="mt-3 text-muted">Belum ada kelas yang tersedia.</h5>
        </div>
        @endif
    </div>
</section>
@endsection