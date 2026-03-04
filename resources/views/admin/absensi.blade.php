@extends('layouts.admin')
@section('title', 'Absensi Latihan — Art-Hub 2.0')
@section('page-title', 'Absensi Latihan')

@section('content')
{{-- Filters --}}
<div class="card card-arthub mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-bold">Event</label>
                <select name="event_id" class="form-select" onchange="this.form.querySelector('[name=jadwal_id]').value='';this.form.submit()">
                    <option value="">— Pilih Event —</option>
                    @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>{{ $ev->nama_event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-bold">Jadwal Latihan</label>
                <select name="jadwal_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Pilih Jadwal —</option>
                    @foreach($jadwals as $j)
                    <option value="{{ $j->id }}" {{ $jadwalId == $j->id ? 'selected' : '' }}>
                        {!! strip_tags($j->labelTrack()) !!} — {{ $j->judul }} ({{ $j->tanggal->format('d/m') }})
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@if($selectedJadwal)
<div class="card card-arthub mb-3">
    <div class="card-body">
        <h6 class="fw-bold">{{ $selectedJadwal->judul }}</h6>
        <p class="mb-1 text-muted">
            {!! $selectedJadwal->labelTrack() !!} •
            📅 {{ $selectedJadwal->tanggal->translatedFormat('d M Y') }} •
            ⏰ {{ $selectedJadwal->waktu_mulai }}–{{ $selectedJadwal->waktu_selesai }}
            @if($selectedJadwal->lokasi) • 📍 {{ $selectedJadwal->lokasi }} @endif
        </p>
    </div>
</div>

<form action="{{ route('admin.update-absensi') }}" method="POST">
    @csrf
    <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
    <input type="hidden" name="event_id" value="{{ $eventId }}">

    <div class="card card-arthub">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Personel</th>
                        <th>Peran</th>
                        <th>Gender</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $i => $a)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $a->personel->nama }}</strong></td>
                        <td>{!! $a->personel->labelPeran() !!}</td>
                        <td>{!! $a->personel->labelGender() !!}</td>
                        <td>
                            <input type="hidden" name="absensi[{{ $i }}][id]" value="{{ $a->id }}">
                            <div class="btn-group btn-group-sm" role="group">
                                <input type="radio" class="btn-check" name="absensi[{{ $i }}][status]" id="h{{ $a->id }}" value="hadir" {{ $a->status === 'hadir' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success" for="h{{ $a->id }}">🟢 Hadir</label>

                                <input type="radio" class="btn-check" name="absensi[{{ $i }}][status]" id="i{{ $a->id }}" value="izin" {{ $a->status === 'izin' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning" for="i{{ $a->id }}">🟡 Izin</label>

                                <input type="radio" class="btn-check" name="absensi[{{ $i }}][status]" id="a{{ $a->id }}" value="absen" {{ $a->status === 'absen' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger" for="a{{ $a->id }}">🔴 Absen</label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Absensi</button>
    </div>
</form>
@else
<div class="text-center py-5 text-muted">
    <i class="bi bi-person-check fs-1"></i>
    <p class="mt-2">Pilih event dan jadwal untuk mengisi absensi.</p>
</div>
@endif
@endsection