@extends('layouts.app')
@section('title', 'Login — Art-Hub')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-scale">
        <div class="text-center mb-4">
            <div style="font-size:3rem;">🎭</div>
            <h2 class="auth-logo">Art-Hub</h2>
            <p class="text-muted small">Masuk ke akun Anda</p>
        </div>

        @if(session('success'))
        <div class="alert alert-arthub alert-success mb-3 py-2">
            <i class="bi bi-check-circle-fill"></i> <small>{{ session('success') }}</small>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus style="border-left:0;">
                </div>
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--cream-200);border:2px solid var(--cream-300);border-right:0;"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required style="border-left:0;">
                </div>
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-gold w-100 py-2 mb-3">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </form>

        <p class="text-center text-muted small mb-0">
            Belum punya akun? <a href="{{ route('register') }}" class="fw-bold" style="color:var(--burgundy-600);">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection