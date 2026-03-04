@extends('layouts.admin')
@section('title', 'Jadwal Multi-Track — Art-Hub 2.0')
@section('page-title', 'Jadwal Multi-Track')

@section('content')
{{-- Event Selector --}}
<div class="card card-arthub mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label fw-bold">Pilih Event</label>
                <select name="event_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Pilih Event —</option>
                    @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>
                        {{ $ev->nama_event }} ({{ $ev->tanggal_event->format('d/m/Y') }})
                    </option>
                    @endforeach
                </select>
            </div>
            @if($selectedEvent)
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addJadwalModal">
                    <i class="bi bi-plus-lg"></i> Tambah Jadwal
                </button>
            </div>
            @endif
        </form>
    </div>
</div>

@if($selectedEvent)
{{-- Timeline Visualization --}}
<div class="row g-3 mb-4">
    @php
    $trackPenari = $jadwals->where('track', 'penari');
    $trackPemusik = $jadwals->where('track', 'pemusik');
    $trackGabung = $jadwals->where('track', 'gabungan');
    @endphp

    {{-- Track Penari --}}
    <div class="col-md-4">
        <div class="card card-arthub h-100">
            <div class="card-header bg-danger bg-opacity-10">
                <h6 class="mb-0">💃 Track Penari <span class="badge bg-danger">{{ $trackPenari->count() }}</span></h6>
            </div>
            <div class="card-body p-2">
                @forelse($trackPenari as $j)
                <div class="border rounded p-2 mb-2 {{ $j->tanggal->isToday() ? 'border-danger' : '' }}">
                    <div class="d-flex justify-content-between">
                        <strong class="small">{{ $j->judul }}</strong>
                        <div>
                            <button class="btn btn-sm p-0" data-bs-toggle="modal" data-bs-target="#editJadwal{{ $j->id }}"><i class="bi bi-pencil text-primary"></i></button>
                            <form action="{{ route('admin.delete-jadwal', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm p-0"><i class="bi bi-x text-danger"></i></button></form>
                        </div>
                    </div>
                    <small class="text-muted">📅 {{ $j->tanggal->format('d/m') }} • ⏰ {{ $j->waktu_mulai }}–{{ $j->waktu_selesai }}</small>
                    @if($j->lokasi)<br><small class="text-muted">📍 {{ $j->lokasi }}</small>@endif
                </div>
                @empty
                <p class="text-muted small text-center py-3">Belum ada jadwal.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Merge Point (Gabungan) --}}
    <div class="col-md-4">
        <div class="card card-arthub h-100">
            <div class="card-header bg-warning bg-opacity-10">
                <h6 class="mb-0">🤝 Latihan Gabungan <span class="badge bg-warning text-dark">{{ $trackGabung->count() }}</span></h6>
            </div>
            <div class="card-body p-2">
                @forelse($trackGabung as $j)
                <div class="border rounded p-2 mb-2 border-warning {{ $j->tanggal->isToday() ? 'border-2' : '' }}">
                    <div class="d-flex justify-content-between">
                        <strong class="small">🔗 {{ $j->judul }}</strong>
                        <div>
                            <button class="btn btn-sm p-0" data-bs-toggle="modal" data-bs-target="#editJadwal{{ $j->id }}"><i class="bi bi-pencil text-primary"></i></button>
                            <form action="{{ route('admin.delete-jadwal', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm p-0"><i class="bi bi-x text-danger"></i></button></form>
                        </div>
                    </div>
                    <small class="text-muted">📅 {{ $j->tanggal->format('d/m') }} • ⏰ {{ $j->waktu_mulai }}–{{ $j->waktu_selesai }}</small>
                    @if($j->lokasi)<br><small class="text-muted">📍 {{ $j->lokasi }}</small>@endif
                    @if($j->catatan)<br><small class="text-info">💬 {{ $j->catatan }}</small>@endif
                </div>
                @empty
                <p class="text-muted small text-center py-3">Belum ada latihan gabung.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Track Pemusik --}}
    <div class="col-md-4">
        <div class="card card-arthub h-100">
            <div class="card-header bg-primary bg-opacity-10">
                <h6 class="mb-0">🎵 Track Pemusik <span class="badge bg-primary">{{ $trackPemusik->count() }}</span></h6>
            </div>
            <div class="card-body p-2">
                @forelse($trackPemusik as $j)
                <div class="border rounded p-2 mb-2 {{ $j->tanggal->isToday() ? 'border-primary' : '' }}">
                    <div class="d-flex justify-content-between">
                        <strong class="small">{{ $j->judul }}</strong>
                        <div>
                            <button class="btn btn-sm p-0" data-bs-toggle="modal" data-bs-target="#editJadwal{{ $j->id }}"><i class="bi bi-pencil text-primary"></i></button>
                            <form action="{{ route('admin.delete-jadwal', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm p-0"><i class="bi bi-x text-danger"></i></button></form>
                        </div>
                    </div>
                    <small class="text-muted">📅 {{ $j->tanggal->format('d/m') }} • ⏰ {{ $j->waktu_mulai }}–{{ $j->waktu_selesai }}</small>
                    @if($j->lokasi)<br><small class="text-muted">📍 {{ $j->lokasi }}</small>@endif
                </div>
                @empty
                <p class="text-muted small text-center py-3">Belum ada jadwal.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Edit Modals for each Jadwal --}}
@foreach($jadwals as $j)
<div class="modal fade" id="editJadwal{{ $j->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.update-jadwal', $j->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Judul</label><input type="text" name="judul" class="form-control" value="{{ $j->judul }}" required></div>
                        <div class="col-md-6"><label class="form-label">Track</label>
                            <select name="track" class="form-select" required>
                                <option value="penari" {{ $j->track === 'penari' ? 'selected' : '' }}>Penari</option>
                                <option value="pemusik" {{ $j->track === 'pemusik' ? 'selected' : '' }}>Pemusik</option>
                                <option value="gabungan" {{ $j->track === 'gabungan' ? 'selected' : '' }}>Gabungan (Merge Point)</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" value="{{ $j->tanggal->format('Y-m-d') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Waktu Mulai</label><input type="time" name="waktu_mulai" class="form-control" value="{{ $j->waktu_mulai }}" required></div>
                        <div class="col-md-6"><label class="form-label">Waktu Selesai</label><input type="time" name="waktu_selesai" class="form-control" value="{{ $j->waktu_selesai }}" required></div>
                        <div class="col-12"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" value="{{ $j->lokasi }}"></div>
                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2">{{ $j->catatan }}</textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- Add Jadwal Modal --}}
<div class="modal fade" id="addJadwalModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store-jadwal') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $eventId }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Latihan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Judul Latihan</label><input type="text" name="judul" class="form-control" placeholder="Contoh: Latihan Gerak 1" required></div>
                        <div class="col-md-6"><label class="form-label">Track</label>
                            <select name="track" class="form-select" required>
                                <option value="penari">💃 Penari</option>
                                <option value="pemusik">🎵 Pemusik</option>
                                <option value="gabungan">🤝 Gabungan (Merge Point)</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Waktu Mulai</label><input type="time" name="waktu_mulai" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Waktu Selesai</label><input type="time" name="waktu_selesai" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Catatan / Instruksi</label><textarea name="catatan" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
            </div>
        </form>
    </div>
</div>
@else
<div class="text-center py-5 text-muted">
    <i class="bi bi-calendar-week fs-1"></i>
    <p class="mt-2">Pilih event untuk melihat jadwal multi-track.</p>
</div>
@endif
@endsection