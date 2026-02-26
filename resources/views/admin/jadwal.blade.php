@extends('layouts.admin')
@section('title', 'Jadwal Pementasan — Art-Hub')
@section('page-title', 'Jadwal Pementasan')

@section('content')
<div class="glass-card p-4 animate-fade-up">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0" style="color:var(--burgundy-700);"><i class="bi bi-calendar3 me-2"></i>Jadwal yang Sudah Disetujui</h6>
        <span class="badge bg-success rounded-pill">{{ $jadwal->total() }} jadwal</span>
    </div>
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Klien</th>
                    <th>Jenis Acara</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Durasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $i => $j)
                <tr>
                    <td>{{ $jadwal->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $j->user->name }}</strong>
                        <br><small class="text-muted">{{ $j->user->no_whatsapp }}</small>
                    </td>
                    <td>
                        <strong>{{ ucfirst($j->jenis_acara) }}</strong>
                    </td>
                    <td>
                        <strong style="color:var(--burgundy-700);">{{ $j->tanggal_pentas->format('d M Y') }}</strong>
                        <br><small class="text-muted">{{ $j->tanggal_pentas->translatedFormat('l') }}</small>
                    </td>
                    <td>{{ $j->waktu_mulai }} — {{ $j->waktu_selesai }}</td>
                    <td><small>{{ Str::limit($j->lokasi_acara, 50) }}</small></td>
                    <td>{{ $j->durasi_jam }} jam</td>
                    <td>
                        <form action="{{ route('admin.cancel-jadwal', $j->id) }}" method="POST" onsubmit="return confirm('Batalkan jadwal ini? Status akan berubah menjadi Ditolak.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Batalkan">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                        Belum ada jadwal pementasan yang disetujui.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $jadwal->links() }}</div>
</div>
@endsection