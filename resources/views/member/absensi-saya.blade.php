@extends('layouts.member')
@section('title', 'Riwayat Absensi — Art-Hub 2.0')
@section('page-title', 'Riwayat Absensi')

@section('content')
<div class="card card-arthub mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label fw-bold">Filter Event</label>
                <select name="event_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Semua Event —</option>
                    @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>{{ $ev->nama_event }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Personel</th>
                    <th>Peran</th>
                    <th>Latihan</th>
                    <th>Event</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $a)
                <tr>
                    <td><strong>{{ $a->personel->nama }}</strong></td>
                    <td>{!! $a->personel->labelPeran() !!}</td>
                    <td>{{ $a->jadwal->judul }}</td>
                    <td>{{ $a->jadwal->event->nama_event }}</td>
                    <td>{{ $a->jadwal->tanggal->translatedFormat('d M Y') }}</td>
                    <td>{!! $a->labelStatus() !!}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data absensi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection