@extends('layouts.member')
@section('title', 'Jadwal Latihan — Art-Hub 2.0')
@section('page-title', 'Jadwal Latihan')

@section('content')
<div class="card card-arthub mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label fw-bold">Filter Event</label>
                <select name="event_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Semua Event Aktif —</option>
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
                    <th>Judul Latihan</th>
                    <th>Event</th>
                    <th>Track</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $j)
                <tr class="{{ $j->is_merge_point ? 'table-warning' : '' }}">
                    <td>
                        <strong>{{ $j->judul }}</strong>
                        @if($j->is_merge_point) <span class="badge bg-warning text-dark">Merge Point</span> @endif
                    </td>
                    <td>{{ $j->event->nama_event }}</td>
                    <td>{!! $j->labelTrack() !!}</td>
                    <td>{{ $j->tanggal->translatedFormat('d M Y') }}</td>
                    <td>{{ $j->waktu_mulai }}–{{ $j->waktu_selesai }}</td>
                    <td>{{ $j->lokasi ?: '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Tidak ada jadwal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection