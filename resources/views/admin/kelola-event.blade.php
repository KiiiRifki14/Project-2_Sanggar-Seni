@extends('layouts.admin')
@section('title', 'Kelola Event — Art-Hub 2.0')
@section('page-title', 'Kelola Event Pementasan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Manajemen seluruh proyek pementasan sanggar.</p>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="bi bi-plus-lg"></i> Tambah Event
    </button>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Klien</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $ev)
                <tr>
                    <td><strong>{{ $ev->nama_event }}</strong></td>
                    <td>{{ $ev->klien }}</td>
                    <td>{{ $ev->tanggal_event->translatedFormat('d M Y') }}</td>
                    <td>{!! $ev->labelJenis() !!}</td>
                    <td>{!! $ev->labelStatus() !!}</td>
                    <td>
                        {!! $ev->labelBayar() !!}
                        @if($ev->nominal_dp > 0)
                        <br><small class="text-muted">DP: Rp {{ number_format($ev->nominal_dp, 0, ',', '.') }}</small>
                        @endif
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $ev->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.delete-event', $ev->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus event ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $ev->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <form action="{{ route('admin.update-event', $ev->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Event</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Event</label>
                                            <input type="text" name="nama_event" class="form-control" value="{{ $ev->nama_event }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Klien</label>
                                            <input type="text" name="klien" class="form-control" value="{{ $ev->klien }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jenis Acara</label>
                                            <select name="jenis_acara" class="form-select" required>
                                                @foreach(['pernikahan','festival','penyambutan','budaya','lainnya'] as $j)
                                                <option value="{{ $j }}" {{ $ev->jenis_acara === $j ? 'selected' : '' }}>{{ ucfirst($j) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" name="tanggal_event" class="form-control" value="{{ $ev->tanggal_event->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                @foreach(['persiapan','berlangsung','selesai','batal'] as $s)
                                                <option value="{{ $s }}" {{ $ev->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Waktu Mulai</label>
                                            <input type="time" name="waktu_mulai" class="form-control" value="{{ $ev->waktu_mulai }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Waktu Selesai</label>
                                            <input type="time" name="waktu_selesai" class="form-control" value="{{ $ev->waktu_selesai }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Status Bayar</label>
                                            <select name="status_bayar" class="form-select">
                                                <option value="belum_dp" {{ $ev->status_bayar === 'belum_dp' ? 'selected' : '' }}>Belum DP</option>
                                                <option value="sudah_dp" {{ $ev->status_bayar === 'sudah_dp' ? 'selected' : '' }}>Sudah DP</option>
                                                <option value="lunas" {{ $ev->status_bayar === 'lunas' ? 'selected' : '' }}>Lunas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Nominal DP</label>
                                            <input type="number" name="nominal_dp" class="form-control" value="{{ $ev->nominal_dp }}" step="1000" min="0">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="lokasi" class="form-control" value="{{ $ev->lokasi }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Catatan</label>
                                            <textarea name="catatan" class="form-control" rows="2">{{ $ev->catatan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada event.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.store-event') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Event Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Event</label>
                            <input type="text" name="nama_event" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Klien</label>
                            <input type="text" name="klien" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Acara</label>
                            <select name="jenis_acara" class="form-select" required>
                                <option value="pernikahan">Pernikahan</option>
                                <option value="festival">Festival</option>
                                <option value="penyambutan">Penyambutan</option>
                                <option value="budaya">Budaya</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Event</label>
                            <input type="date" name="tanggal_event" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status Bayar</label>
                            <select name="status_bayar" class="form-select">
                                <option value="belum_dp">Belum DP</option>
                                <option value="sudah_dp">Sudah DP</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nominal DP</label>
                            <input type="number" name="nominal_dp" class="form-control" value="0" step="1000" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Event</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection