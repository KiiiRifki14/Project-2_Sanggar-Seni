@extends('layouts.member')
@section('title', 'Profil Saya — Art-Hub 2.0')
@section('page-title', 'Akun Saya')

@section('content')
<div class="card card-arthub">
    <div class="card-body">
        <form action="{{ route('member.profil.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" name="no_whatsapp" class="form-control" value="{{ $user->no_whatsapp }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ $user->tempat_lahir }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ $user->roleName() }}" disabled>
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ $user->alamat }}</textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Profil</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection