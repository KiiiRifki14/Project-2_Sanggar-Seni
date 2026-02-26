@extends('layouts.admin')
@section('title', 'Validasi Pendaftaran Les — Art-Hub')
@section('page-title', 'Validasi Pendaftaran Les')

@section('content')
<div class="glass-card p-4 animate-fade-up">
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pendaftar</th>
                    <th>Kelas</th>
                    <th>TTL</th>
                    <th>Asal Sekolah</th>
                    <th>Orang Tua</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $i => $p)
                <tr>
                    <td>{{ $pendaftaran->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $p->user->name }}</strong>
                        <br><small class="text-muted">{{ $p->user->no_whatsapp }}</small>
                    </td>
                    <td>
                        <span class="kelas-badge {{ $p->kelas->kategori }}">{{ ucfirst($p->kelas->kategori) }}</span>
                        <br><small class="fw-bold">{{ $p->kelas->nama_kelas }}</small>
                    </td>
                    <td><small>{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir->format('d/m/Y') }}</small></td>
                    <td><small>{{ $p->asal_sekolah }}</small></td>
                    <td>
                        <small>{{ $p->nama_orang_tua }}</small>
                        <br><small class="text-muted">{{ $p->no_hp_ortu }}</small>
                    </td>
                    <td><small>{{ $p->created_at->format('d M Y') }}</small></td>
                    <td><span class="badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td>
                        @if($p->status === 'menunggu')
                        <div class="d-flex gap-1">
                            <form action="{{ route('admin.process-les', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="diterima">
                                <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $p->id }}" title="Tolak">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        {{-- Reject Modal --}}
                        <div class="modal fade" id="rejectModal{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.process-les', $p->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="ditolak">
                                        <div class="modal-header" style="background:var(--burgundy-700);color:white;">
                                            <h6 class="modal-title">Tolak Pendaftaran</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="small">Pendaftaran <strong>{{ $p->user->name }}</strong> untuk kelas <strong>{{ $p->kelas->nama_kelas }}</strong> akan ditolak.</p>
                                            <label class="form-label">Alasan Penolakan (opsional)</label>
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
                        <small class="text-muted">{{ $p->catatan_admin ?? '—' }}</small>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada data pendaftaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-center">
        {{ $pendaftaran->links() }}
    </div>
</div>
@endsection