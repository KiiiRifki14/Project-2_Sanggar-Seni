@extends('layouts.admin')
@section('title', 'Sewa Kostum — Art-Hub 2.0')
@section('page-title', 'Tracking Sewa Kostum')

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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Tambah Sewa</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Kostum</th>
                    <th>Vendor</th>
                    <th>Event</th>
                    <th>Qty</th>
                    <th>Biaya</th>
                    <th>Ambil</th>
                    <th>Kembali</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sewas as $s)
                <tr class="{{ $s->isOverdue() ? 'table-danger' : '' }}">
                    <td><strong>{{ $s->nama_kostum }}</strong></td>
                    <td>{{ $s->vendor->nama_vendor }}</td>
                    <td>{{ $s->event->nama_event }}</td>
                    <td>{{ $s->jumlah }}</td>
                    <td>Rp {{ number_format($s->biaya_sewa, 0, ',', '.') }}</td>
                    <td>{{ $s->tanggal_ambil ? $s->tanggal_ambil->format('d/m/Y') : '-' }}</td>
                    <td>
                        {{ $s->tanggal_kembali ? $s->tanggal_kembali->format('d/m/Y') : '-' }}
                        @if($s->isOverdue()) <span class="badge bg-danger">TERLAMBAT!</span> @endif
                    </td>
                    <td>{!! $s->labelStatus() !!}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $s->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.delete-sewa-kostum', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $s->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.update-sewa-kostum', $s->id) }}" method="POST">@csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Sewa Kostum</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Vendor</label><select name="vendor_id" class="form-select" required>@foreach($vendors as $v)<option value="{{ $v->id }}" {{ $s->vendor_id === $v->id ? 'selected' : '' }}>{{ $v->nama_vendor }}</option>@endforeach</select></div>
                                        <div class="col-md-6"><label class="form-label">Nama Kostum</label><input type="text" name="nama_kostum" class="form-control" value="{{ $s->nama_kostum }}" required></div>
                                        <div class="col-md-4"><label class="form-label">Jumlah</label><input type="number" name="jumlah" class="form-control" value="{{ $s->jumlah }}" min="1" required></div>
                                        <div class="col-md-4"><label class="form-label">Biaya Sewa</label><input type="number" name="biaya_sewa" class="form-control" value="{{ $s->biaya_sewa }}" min="0" required></div>
                                        <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">
                                                <option value="dipesan" {{ $s->status === 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                                                <option value="diambil" {{ $s->status === 'diambil' ? 'selected' : '' }}>Diambil</option>
                                                <option value="dikembalikan" {{ $s->status === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                                <option value="terlambat" {{ $s->status === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                            </select></div>
                                        <div class="col-md-6"><label class="form-label">Tgl Ambil</label><input type="date" name="tanggal_ambil" class="form-control" value="{{ $s->tanggal_ambil ? $s->tanggal_ambil->format('Y-m-d') : '' }}"></div>
                                        <div class="col-md-6"><label class="form-label">Tgl Kembali</label><input type="date" name="tanggal_kembali" class="form-control" value="{{ $s->tanggal_kembali ? $s->tanggal_kembali->format('Y-m-d') : '' }}"></div>
                                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2">{{ $s->catatan }}</textarea></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">Belum ada data sewa kostum.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store-sewa-kostum') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sewa Kostum</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Event</label><select name="event_id" class="form-select" required>@foreach($events as $ev)<option value="{{ $ev->id }}" {{ $eventId == $ev->id ? 'selected' : '' }}>{{ $ev->nama_event }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Vendor</label><select name="vendor_id" class="form-select" required>@foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->nama_vendor }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label class="form-label">Nama Kostum</label><input type="text" name="nama_kostum" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Jumlah</label><input type="number" name="jumlah" class="form-control" value="1" min="1" required></div>
                        <div class="col-md-3"><label class="form-label">Biaya (Rp)</label><input type="number" name="biaya_sewa" class="form-control" min="0" required></div>
                        <div class="col-md-6"><label class="form-label">Tgl Ambil</label><input type="date" name="tanggal_ambil" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Tgl Kembali (Deadline)</label><input type="date" name="tanggal_kembali" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
            </div>
        </form>
    </div>
</div>
@endsection