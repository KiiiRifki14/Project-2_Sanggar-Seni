@extends('layouts.member')
@section('title', 'Sewa Panggung — Art-Hub')
@section('page-title', 'Reservasi Pementasan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 animate-fade-up">
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;background:linear-gradient(135deg,var(--gold-500),var(--gold-400));color:var(--burgundy-900);">
                    <i class="bi bi-calendar-event fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color:var(--burgundy-700);">Formulir Sewa Panggung</h5>
                    <small class="text-muted">Isi detail acara Anda untuk memesan jasa pementasan</small>
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

            <form method="POST" action="{{ route('member.store-booking') }}" class="form-arthub">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Acara <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_acara" required>
                            <option value="">— Pilih Jenis Acara —</option>
                            <option value="pernikahan" {{ old('jenis_acara') === 'pernikahan' ? 'selected' : '' }}>🎊 Pernikahan / Hajatan</option>
                            <option value="penyambutan" {{ old('jenis_acara') === 'penyambutan' ? 'selected' : '' }}>🎉 Penyambutan / Upacara</option>
                            <option value="festival" {{ old('jenis_acara') === 'festival' ? 'selected' : '' }}>🎪 Festival Seni Budaya</option>
                            <option value="lainnya" {{ old('jenis_acara') === 'lainnya' ? 'selected' : '' }}>📋 Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pentas <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_pentas" value="{{ old('tanggal_pentas') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Lokasi / Alamat Acara <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="lokasi_acara" rows="2" required placeholder="contoh: Gedung Serbaguna, Jl. Asia Afrika No. 50, Bandung">{{ old('lokasi_acara') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi / Catatan Tambahan</label>
                        <textarea class="form-control" name="deskripsi_acara" rows="3" placeholder="Ceritakan detail acara Anda (opsional)...">{{ old('deskripsi_acara') }}</textarea>
                    </div>
                </div>

                <div class="alert alert-warning mt-3 small" style="border-radius:var(--radius-sm);">
                    <i class="bi bi-info-circle me-1"></i> Setelah mengirim pesanan, Anda akan diarahkan untuk mengirimkan pesan konfirmasi ke Admin via <strong>WhatsApp</strong>.
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('member.dashboard') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-gold"><i class="bi bi-send me-1"></i> Pesan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection