@extends('layouts.app')
@section('title', 'Daftar Akun — Art-Hub')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-scale" style="max-width:500px;">
        <div class="text-center mb-4">
            <div style="font-size:3rem;">🎭</div>
            <h2 class="auth-logo">Buat Akun Baru</h2>
            <p class="text-muted small">Bergabunglah dengan Art-Hub untuk mendaftar les atau memesan jasa pementasan</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required style="border-left:0;">
                </div>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required style="border-left:0;">
                </div>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_whatsapp" class="form-label">Nomor WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-whatsapp"></i></span>
                    <input type="text" class="form-control @error('no_whatsapp') is-invalid @enderror" id="no_whatsapp" name="no_whatsapp" value="{{ old('no_whatsapp') }}" placeholder="contoh: 08123456789" required style="border-left:0;">
                </div>
                @error('no_whatsapp')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required style="border-left:0;">
                </div>
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required style="border-left:0;">
                </div>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2 mb-3">
                <i class="bi bi-person-plus"></i> Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-muted small mb-0">
            Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold" style="color:var(--burgundy-600);">Login di sini</a>
        </p>
    </div>
</div>
@endsection