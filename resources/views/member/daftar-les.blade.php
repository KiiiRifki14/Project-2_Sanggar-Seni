@extends('layouts.member')
@section('title', 'Daftar Les — Art-Hub')
@section('page-title', 'Pendaftaran Les Seni')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 animate-fade-up">
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;background:linear-gradient(135deg,var(--burgundy-600),var(--burgundy-700));color:var(--gold-400);">
                    <i class="bi bi-pencil-square fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color:var(--burgundy-700);">Formulir Pendaftaran Les</h5>
                    <small class="text-muted">Lengkapi biodata untuk mendaftar kelas seni</small>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-arthub alert-danger mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    @foreach($errors->all() as $error)
                    <small class="d-block">{{ $error }}</small>
                    @endforeach
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('member.store-les') }}" class="form-arthub">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Kelas <span class="text-danger">*</span></label>
                    <select class="form-select" name="kelas_id" required>
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} — Rp {{ number_format($k->biaya, 0, ',', '.') }}/bln ({{ $k->jadwal }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <h6 class="fw-bold mt-4 mb-3" style="color:var(--burgundy-700);">Biodata Calon Murid</h6>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="contoh: Bandung">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="asal_sekolah" value="{{ old('asal_sekolah') }}" required placeholder="contoh: SMPN 1 Bandung">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Orang Tua/Wali <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP Orang Tua <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_hp_ortu" value="{{ old('no_hp_ortu') }}" required placeholder="contoh: 081234567890">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-gold"><i class="bi bi-send me-1"></i> Kirim Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection