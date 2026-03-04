@extends('layouts.admin')
@section('title', 'Kelola Kostum — Art-Hub')
@section('page-title', 'Arsip Kostum & Properti')

@section('content')
{{-- Form Tambah Kostum --}}
<div class="glass-card p-4 mb-4 animate-fade-up delay-1">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-plus-circle me-2"></i>Daftarkan Kostum / Properti</h6>
    <form action="{{ route('admin.store-kostum') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Kostum / Properti <span class="text-danger">*</span></label>
                <input type="text" name="nama_kostum" class="form-control" value="{{ old('nama_kostum') }}" required>
                @error('nama_kostum')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select" required>
                    <option value="tari" {{ old('kategori') == 'tari' ? 'selected' : '' }}>🎭 Tari</option>
                    <option value="musik" {{ old('kategori') == 'musik' ? 'selected' : '' }}>🎵 Musik</option>
                    <option value="teater" {{ old('kategori') == 'teater' ? 'selected' : '' }}>🎬 Teater</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kondisi Fisik <span class="text-danger">*</span></label>
                <select name="kondisi_fisik" class="form-select" required>
                    <option value="baik" {{ old('kondisi_fisik', 'baik') == 'baik' ? 'selected' : '' }}>🟢 Baik</option>
                    <option value="cukup" {{ old('kondisi_fisik') == 'cukup' ? 'selected' : '' }}>🟡 Cukup</option>
                    <option value="rusak" {{ old('kondisi_fisik') == 'rusak' ? 'selected' : '' }}>🔴 Rusak</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Aksesoris</label>
                <input type="text" name="nama_aksesoris" class="form-control" value="{{ old('nama_aksesoris') }}" placeholder="Siger, Gelang, Sampur...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Foto Kostum</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Makna Warna</label>
                <textarea name="makna_warna" class="form-control" rows="2">{{ old('makna_warna') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Makna Ornamen</label>
                <textarea name="makna_ornamen" class="form-control" rows="2">{{ old('makna_ornamen') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-burgundy mt-3"><i class="bi bi-save me-2"></i>Simpan Kostum</button>
    </form>
</div>

{{-- Daftar Kostum --}}
<div class="glass-card p-4 animate-fade-up delay-2">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-palette me-2"></i>Daftar Kostum & Properti ({{ $kostum->total() }})</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Kondisi</th>
                    <th>Aksesoris</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kostum as $idx => $k)
                <tr>
                    <td>{{ $kostum->firstItem() + $idx }}</td>
                    <td>
                        <strong>{{ $k->nama_kostum }}</strong>
                        <br><small class="text-muted">{{ Str::limit($k->deskripsi, 50) }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ ucfirst($k->kategori) }}</span></td>
                    <td>{{ $k->labelKondisi() }}</td>
                    <td><small>{{ $k->nama_aksesoris ?? '—' }}</small></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editKostumModal{{ $k->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.delete-kostum', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kostum ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editKostumModal{{ $k->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.update-kostum', $k->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit: {{ $k->nama_kostum }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Kostum</label><input type="text" name="nama_kostum" class="form-control" value="{{ $k->nama_kostum }}" required></div>
                                        <div class="col-md-3"><label class="form-label fw-semibold">Kategori</label><select name="kategori" class="form-select" required>
                                                <option value="tari" {{ $k->kategori == 'tari' ? 'selected' : '' }}>Tari</option>
                                                <option value="musik" {{ $k->kategori == 'musik' ? 'selected' : '' }}>Musik</option>
                                                <option value="teater" {{ $k->kategori == 'teater' ? 'selected' : '' }}>Teater</option>
                                            </select></div>
                                        <div class="col-md-3"><label class="form-label fw-semibold">Kondisi</label><select name="kondisi_fisik" class="form-select" required>
                                                <option value="baik" {{ $k->kondisi_fisik == 'baik' ? 'selected' : '' }}>Baik</option>
                                                <option value="cukup" {{ $k->kondisi_fisik == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                                <option value="rusak" {{ $k->kondisi_fisik == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                            </select></div>
                                        <div class="col-12"><label class="form-label fw-semibold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2">{{ $k->deskripsi }}</textarea></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Aksesoris</label><input type="text" name="nama_aksesoris" class="form-control" value="{{ $k->nama_aksesoris }}"></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Foto</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Makna Warna</label><textarea name="makna_warna" class="form-control" rows="2">{{ $k->makna_warna }}</textarea></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Makna Ornamen</label><textarea name="makna_ornamen" class="form-control" rows="2">{{ $k->makna_ornamen }}</textarea></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-burgundy">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data kostum.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $kostum->links() }}</div>
</div>
@endsection