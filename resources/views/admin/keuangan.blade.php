@extends('layouts.admin')
@section('title', 'Kalkulator Laba — Art-Hub 2.0')
@section('page-title', 'Kalkulator Laba Bersih')

@section('content')
<div class="card card-arthub mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-10">
                <label class="form-label fw-bold">Pilih Event</label>
                <select name="event_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Pilih Event —</option>
                    @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>{{ $ev->nama_event }} ({{ $ev->tanggal_event->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@if($keuangan && $selectedEvent)
<form action="{{ route('admin.update-keuangan', $keuangan->id) }}" method="POST">
    @csrf @method('PUT')

    {{-- Deal Price --}}
    <div class="card card-arthub mb-4">
        <div class="card-header bg-success bg-opacity-10">
            <h6 class="mb-0 text-success"><i class="bi bi-cash-coin me-1"></i> Harga Deal Klien</h6>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="form-label">Harga Kesepakatan (Rp)</label>
                    <input type="number" name="harga_deal" class="form-control form-control-lg" value="{{ $keuangan->harga_deal }}" min="0" step="1000">
                </div>
                <div class="col-md-6">
                    <p class="mb-0 text-muted">
                        <i class="bi bi-info-circle"></i> Harga ini otomatis ter-update jika Anda menetapkan Deal di halaman Negosiasi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Estimasi vs Realisasi --}}
    <div class="row g-4 mb-4">
        {{-- Estimasi --}}
        <div class="col-lg-6">
            <div class="card card-arthub h-100">
                <div class="card-header bg-warning bg-opacity-10">
                    <h6 class="mb-0 text-warning"><i class="bi bi-calculator me-1"></i> Estimasi Biaya</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">🍽️ Konsumsi</label>
                        <input type="number" name="estimasi_konsumsi" class="form-control" value="{{ $keuangan->estimasi_konsumsi }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">🚗 Transport</label>
                        <input type="number" name="estimasi_transport" class="form-control" value="{{ $keuangan->estimasi_transport }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">👗 Sewa Kostum</label>
                        <input type="number" name="estimasi_sewa_kostum" class="form-control" value="{{ $keuangan->estimasi_sewa_kostum }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">💰 Honor Personel</label>
                        <input type="number" name="estimasi_honor" class="form-control" value="{{ $keuangan->estimasi_honor }}" min="0" step="1000">
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Estimasi Biaya:</strong>
                        <strong class="text-warning">Rp {{ number_format($keuangan->estimasi_total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <strong>Estimasi Laba:</strong>
                        <strong class="{{ $keuangan->estimasi_laba >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($keuangan->estimasi_laba, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Realisasi --}}
        <div class="col-lg-6">
            <div class="card card-arthub h-100">
                <div class="card-header bg-primary bg-opacity-10">
                    <h6 class="mb-0 text-primary"><i class="bi bi-receipt me-1"></i> Realisasi Biaya</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">🍽️ Konsumsi</label>
                        <input type="number" name="real_konsumsi" class="form-control" value="{{ $keuangan->real_konsumsi }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">🚗 Transport</label>
                        <input type="number" name="real_transport" class="form-control" value="{{ $keuangan->real_transport }}" min="0" step="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">👗 Sewa Kostum <small class="text-muted">(auto-sync)</small></label>
                        <input type="number" name="real_sewa_kostum" class="form-control" value="{{ $keuangan->real_sewa_kostum }}" min="0" step="1000">
                        <small class="text-muted">Otomatis ter-update dari data Sewa Kostum.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">💰 Honor Personel</label>
                        <input type="number" name="real_honor" class="form-control" value="{{ $keuangan->real_honor }}" min="0" step="1000">
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Biaya Riil:</strong>
                        <strong class="text-primary">Rp {{ number_format($keuangan->real_total, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <strong>Laba Bersih Riil:</strong>
                        <strong class="{{ $keuangan->real_laba >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format($keuangan->real_laba, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Selisih Summary --}}
    <div class="card card-arthub mb-4 {{ $keuangan->selisih >= 0 ? 'border-success' : 'border-danger' }}">
        <div class="card-body text-center">
            <h5>📊 Perbandingan Estimasi vs Realisasi</h5>
            <div class="row mt-3">
                <div class="col-md-4">
                    <h6 class="text-muted">Estimasi Laba</h6>
                    <h4 class="{{ $keuangan->estimasi_laba >= 0 ? 'text-success' : 'text-danger' }}">Rp {{ number_format($keuangan->estimasi_laba, 0, ',', '.') }}</h4>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted">Laba Bersih Riil</h6>
                    <h4 class="{{ $keuangan->real_laba >= 0 ? 'text-success' : 'text-danger' }}">Rp {{ number_format($keuangan->real_laba, 0, ',', '.') }}</h4>
                </div>
                <div class="col-md-4">
                    <h6 class="text-muted">Selisih</h6>
                    <h4 class="{{ $keuangan->selisih >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $keuangan->selisih >= 0 ? '+' : '' }}Rp {{ number_format($keuangan->selisih, 0, ',', '.') }}
                        <br><small class="fw-normal">{{ $keuangan->selisih >= 0 ? '✅ Hemat' : '⚠️ Over Budget' }}</small>
                    </h4>
                </div>
            </div>
            <p class="text-muted mt-3 mb-0">
                <strong>Rumus:</strong> Laba Bersih = Harga Deal − (Konsumsi + Transport + Sewa Kostum + Honor Personel)
            </p>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save me-1"></i> Simpan Data Keuangan</button>
    </div>
</form>
@else
<div class="text-center py-5 text-muted">
    <i class="bi bi-calculator fs-1"></i>
    <p class="mt-2">Pilih event untuk mengelola data keuangan.</p>
</div>
@endif
@endsection