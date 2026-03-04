@extends('layouts.admin')
@section('title', 'Kelola Vendor — Art-Hub 2.0')
@section('page-title', 'Kelola Vendor Kostum')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Daftar penyedia sewa kostum langganan.</p>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Tambah Vendor</button>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Vendor</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Catatan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $v)
                <tr>
                    <td><strong>{{ $v->nama_vendor }}</strong></td>
                    <td>{{ $v->kontak }}</td>
                    <td>{{ Str::limit($v->alamat, 40) ?: '-' }}</td>
                    <td>{{ Str::limit($v->catatan, 40) ?: '-' }}</td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $v->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.delete-vendor', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $v->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.update-vendor', $v->id) }}" method="POST">@csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Vendor</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama Vendor</label><input type="text" name="nama_vendor" class="form-control" value="{{ $v->nama_vendor }}" required></div>
                                        <div class="col-12"><label class="form-label">Kontak</label><input type="text" name="kontak" class="form-control" value="{{ $v->kontak }}" required></div>
                                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2">{{ $v->alamat }}</textarea></div>
                                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2">{{ $v->catatan }}</textarea></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada vendor.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store-vendor') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Vendor</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Nama Vendor</label><input type="text" name="nama_vendor" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Kontak</label><input type="text" name="kontak" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><label class="form-label">Catatan</label><textarea name="catatan" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
            </div>
        </form>
    </div>
</div>
@endsection