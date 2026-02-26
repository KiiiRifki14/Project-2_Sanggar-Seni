@extends('layouts.admin')
@section('title', 'Data Siswa — Art-Hub')
@section('page-title', 'Data Siswa Aktif')

@section('content')
<div class="glass-card p-4 animate-fade-up">
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>TTL</th>
                    <th>Sekolah</th>
                    <th>Orang Tua</th>
                    <th>No HP Ortu</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                <tr>
                    <td>{{ $siswa->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $s->user->name }}</strong>
                        <br><small class="text-muted">{{ $s->user->email }}</small>
                    </td>
                    <td>
                        <span class="kelas-badge {{ $s->kelas->kategori }}">{{ ucfirst($s->kelas->kategori) }}</span>
                        <br><small class="fw-bold">{{ $s->kelas->nama_kelas }}</small>
                    </td>
                    <td><small>{{ $s->tempat_lahir }}, {{ $s->tanggal_lahir->format('d/m/Y') }}</small></td>
                    <td><small>{{ $s->asal_sekolah }}</small></td>
                    <td><small>{{ $s->nama_orang_tua }}</small></td>
                    <td><small>{{ $s->no_hp_ortu }}</small></td>
                    <td><small>{{ $s->created_at->format('d M Y') }}</small></td>
                    <td>
                        <form action="{{ route('admin.delete-siswa', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini dari daftar? Data pendaftarannya akan dihapus.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="bi bi-people fs-3 d-block mb-2"></i>
                        Belum ada siswa aktif.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $siswa->links() }}</div>
</div>
@endsection