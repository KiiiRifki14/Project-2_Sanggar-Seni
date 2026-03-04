@extends('layouts.admin')
@section('title', 'Negosiasi — Art-Hub 2.0')
@section('page-title', 'Log Negosiasi Harga')

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
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Tambah Penawaran</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Tanggal</th>
                    <th>Pihak</th>
                    <th>Harga Penawaran</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($negosiasis as $n)
                <tr class="{{ $n->is_deal ? 'table-success' : '' }}">
                    <td>{{ $n->event->nama_event }}</td>
                    <td>{{ $n->tanggal->format('d/m/Y') }}</td>
                    <td>{!! $n->labelPihak() !!}</td>
                    <td><strong>Rp {{ number_format($n->harga_penawaran, 0, ',', '.') }}</strong></td>
                    <td>{{ Str::limit($n->catatan, 50) ?: '-' }}</td>
                    <td>
                        @if($n->is_deal)
                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> DEAL</span>
                        @else
                        <span class="badge bg-secondary">Penawaran</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if(!$n->is_deal)
                        <form action="{{ route('admin.set-deal', $n->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tetapkan harga ini sebagai DEAL?')">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i> Set Deal</button>
                        </form>
                        @else
                        <span class="text-success fw-bold">✅ Final</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data negosiasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store-negosiasi') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penawaran</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Event</label><select name="event_id" class="form-select" required>@foreach($events as $ev)<option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>{{ $ev->nama_event }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Penawaran</label><input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Diajukan Oleh</label><select name="pihak" class="form-select" required>
                                <option value="klien">👤 Klien</option>
                                <option value="sanggar">🏠 Sanggar</option>
                            </select></div>
                        <div class="col-12"><label class="form-label">Harga Penawaran (Rp)</label><input type="number" name="harga_penawaran" class="form-control" min="0" step="1000" required></div>
                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2" placeholder="Detail penawaran..."></textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
            </div>
        </form>
    </div>
</div>
@endsection