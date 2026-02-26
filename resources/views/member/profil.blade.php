@extends('layouts.member')
@section('title', 'Akun Saya — Art-Hub')
@section('page-title', 'Akun Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 animate-fade-up">
            <div class="text-center mb-4">
                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;background:linear-gradient(135deg,var(--burgundy-600),var(--burgundy-700));color:var(--gold-400);font-size:2rem;font-weight:bold;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h5 class="fw-bold" style="color:var(--burgundy-700);">{{ $user->name }}</h5>
                <span class="badge bg-secondary">Member</span>
            </div>

            <form method="POST" action="{{ route('member.profil.update') }}" class="form-arthub">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" class="form-control @error('no_whatsapp') is-invalid @enderror" name="no_whatsapp" value="{{ old('no_whatsapp', $user->no_whatsapp) }}" required>
                        @error('no_whatsapp')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-gold"><i class="bi bi-check-lg me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection