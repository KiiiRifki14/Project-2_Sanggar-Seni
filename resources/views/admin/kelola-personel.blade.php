@extends('layouts.admin')
@section('title', 'Kelola Personel — Art-Hub 2.0')
@section('page-title', 'Kelola Personel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <span class="badge bg-danger me-1">Penari Putra: {{ $countPenariL }}</span>
        <span class="badge bg-info me-1">Penari Putri: {{ $countPenariP }}</span>
        <span class="badge bg-primary">Pemusik: {{ $countPemusik }}</span>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Tambah Personel</button>
</div>

<div class="card card-arthub">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Peran</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personels as $p)
                <tr class="{{ !$p->is_active ? 'opacity-50' : '' }}">
                    <td><strong>{{ $p->nama }}</strong></td>
                    <td>{!! $p->labelGender() !!}</td>
                    <td>{!! $p->labelPeran() !!}</td>
                    <td>{{ $p->no_whatsapp ?: '-' }}</td>
                    <td><span class="badge bg-{{ $p->is_active ? 'success' : 'secondary' }}">{{ $p->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.delete-personel', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('admin.update-personel', $p->id) }}" method="POST">@csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Personel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-12"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="{{ $p->nama }}" required></div>
                                        <div class="col-md-6"><label class="form-label">Gender</label><select name="jenis_kelamin" class="form-select" required>
                                                <option value="L" {{ $p->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="P" {{ $p->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                                            </select></div>
                                        <div class="col-md-6"><label class="form-label">Peran</label><select name="peran" class="form-select" required>
                                                <option value="penari" {{ $p->peran === 'penari' ? 'selected' : '' }}>Penari</option>
                                                <option value="pemusik" {{ $p->peran === 'pemusik' ? 'selected' : '' }}>Pemusik</option>
                                            </select></div>
                                        <div class="col-md-6"><label class="form-label">WhatsApp</label><input type="text" name="no_whatsapp" class="form-control" value="{{ $p->no_whatsapp }}"></div>
                                        <div class="col-md-6"><label class="form-label">Status</label>
                                            <div class="form-check form-switch mt-2"><input class="form-check-input" type="checkbox" name="is_active" {{ $p->is_active ? 'checked' : '' }}><label class="form-check-label">Aktif</label></div>
                                        </div>
                                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2">{{ $p->alamat }}</textarea></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada personel.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.store-personel') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Personel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Gender</label><select name="jenis_kelamin" class="form-select" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select></div>
                        <div class="col-md-6"><label class="form-label">Peran</label><select name="peran" class="form-select" required>
                                <option value="penari">Penari</option>
                                <option value="pemusik">Pemusik</option>
                            </select></div>
                        <div class="col-12"><label class="form-label">WhatsApp</label><input type="text" name="no_whatsapp" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Tambah</button></div>
            </div>
        </form>
    </div>
</div>
@endsection