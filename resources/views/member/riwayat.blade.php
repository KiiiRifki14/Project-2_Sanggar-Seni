@extends('layouts.member')
@section('title', 'Riwayat — Art-Hub')
@section('page-title', 'Riwayat Aktivitas')

@section('content')
{{-- Riwayat Pendaftaran Les --}}
<div class="glass-card p-4 mb-4 animate-fade-up">
    <h5 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-pencil-square me-2"></i>Riwayat Pendaftaran Les</h5>

    @if($pendaftaran->count() > 0)
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftaran as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $p->kelas->nama_kelas }}</strong>
                        <br><small class="text-muted">{{ ucfirst($p->kelas->kategori) }}</small>
                    </td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                    <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td><small class="text-muted">{{ $p->catatan_admin ?? '-' }}</small></td>
                    <td>
                        @if($p->status === 'diterima')
                        <a href="{{ route('member.cetak-bukti', $p->id) }}" class="btn btn-sm btn-burgundy" target="_blank">
                            <i class="bi bi-printer me-1"></i> Cetak
                        </a>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Belum ada riwayat pendaftaran les.</p>
    @endif
</div>

{{-- Riwayat Booking Pentas --}}
<div class="glass-card p-4 animate-fade-up delay-2">
    <h5 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-calendar-event me-2"></i>Riwayat Booking Pementasan</h5>

    @if($booking->count() > 0)
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Acara</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ ucfirst($b->jenis_acara) }}</strong></td>
                    <td>{{ $b->tanggal_pentas->format('d M Y') }}</td>
                    <td>{{ $b->waktu_mulai }} — {{ $b->waktu_selesai }}</td>
                    <td><small>{{ Str::limit($b->lokasi_acara, 40) }}</small></td>
                    <td><span class="badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    <td><small class="text-muted">{{ $b->catatan_admin ?? '-' }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> Belum ada riwayat booking pementasan.</p>
    @endif
</div>
@endsection