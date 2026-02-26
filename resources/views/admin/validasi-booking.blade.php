@extends('layouts.admin')
@section('title', 'Validasi Booking — Art-Hub')
@section('page-title', 'Validasi Booking Pementasan')

@section('content')
<div class="glass-card p-4 animate-fade-up">
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Klien</th>
                    <th>Jenis Acara</th>
                    <th>Tanggal & Waktu</th>
                    <th>Lokasi</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($booking as $i => $b)
                <tr>
                    <td>{{ $booking->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $b->user->name }}</strong>
                        <br><small class="text-muted">{{ $b->user->no_whatsapp }}</small>
                    </td>
                    <td><strong>{{ ucfirst($b->jenis_acara) }}</strong></td>
                    <td>
                        <strong>{{ $b->tanggal_pentas->format('d M Y') }}</strong>
                        <br><small class="text-muted">{{ $b->waktu_mulai }} — {{ $b->waktu_selesai }}</small>
                    </td>
                    <td><small>{{ Str::limit($b->lokasi_acara, 50) }}</small></td>
                    <td>{{ $b->durasi_jam }} jam</td>
                    <td><span class="badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    <td>
                        @if($b->status === 'menunggu')
                        <div class="d-flex gap-1">
                            <form action="{{ route('admin.process-booking', $b->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit" class="btn btn-sm btn-success" title="Setujui Jadwal">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectBooking{{ $b->id }}" title="Tolak">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="modal fade" id="rejectBooking{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.process-booking', $b->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="ditolak">
                                        <div class="modal-header" style="background:var(--burgundy-700);color:white;">
                                            <h6 class="modal-title">Tolak Booking</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">Booking <strong>{{ ucfirst($b->jenis_acara) }}</strong> oleh <strong>{{ $b->user->name }}</strong> akan ditolak.</p>
                                            <label class="form-label">Alasan (opsional)</label>
                                            <textarea class="form-control" name="catatan_admin" rows="3" placeholder="Tuliskan alasan..."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @else
                        <small class="text-muted">{{ $b->catatan_admin ?? '—' }}</small>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada data booking.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-center">
        {{ $booking->links() }}
    </div>
</div>
@endsection