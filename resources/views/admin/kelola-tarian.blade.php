@extends('layouts.admin')
@section('title', 'Kelola Tarian — Art-Hub')
@section('page-title', 'E-Encyclopedia — Kelola Tarian')

@section('content')
{{-- Form Tambah Tarian --}}
<div class="glass-card p-4 mb-4 animate-fade-up delay-1">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-plus-circle me-2"></i>Tambah Tarian Baru</h6>
    <form action="{{ route('admin.store-tarian') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Tarian <span class="text-danger">*</span></label>
                <input type="text" name="nama_tarian" class="form-control" value="{{ old('nama_tarian') }}" required>
                @error('nama_tarian')<small class="text-danger">{{ $message }}</small>@enderror
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
                <label class="form-label fw-semibold">Tingkat Kesulitan <span class="text-danger">*</span></label>
                <select name="tingkat_kesulitan" class="form-select" required>
                    <option value="mudah" {{ old('tingkat_kesulitan') == 'mudah' ? 'selected' : '' }}>🟢 Mudah</option>
                    <option value="menengah" {{ old('tingkat_kesulitan', 'menengah') == 'menengah' ? 'selected' : '' }}>🟡 Menengah</option>
                    <option value="sulit" {{ old('tingkat_kesulitan') == 'sulit' ? 'selected' : '' }}>🔴 Sulit</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Filosofi Gerakan</label>
                <textarea name="filosofi_gerakan" class="form-control" rows="3">{{ old('filosofi_gerakan') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Sejarah Singkat</label>
                <textarea name="sejarah_singkat" class="form-control" rows="3">{{ old('sejarah_singkat') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Link Video Referensi</label>
                <input type="url" name="link_video_referensi" class="form-control" value="{{ old('link_video_referensi') }}" placeholder="https://youtube.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Foto Tarian</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-burgundy mt-3"><i class="bi bi-save me-2"></i>Simpan Tarian</button>
    </form>
</div>

{{-- Daftar Tarian --}}
<div class="glass-card p-4 animate-fade-up delay-2">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-book me-2"></i>Katalog Tarian ({{ $tarian->total() }} terdaftar)</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Kesulitan</th>
                    <th>Video</th>
                    <th style="width:15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarian as $idx => $t)
                <tr>
                    <td>{{ $tarian->firstItem() + $idx }}</td>
                    <td>
                        <strong>{{ $t->nama_tarian }}</strong>
                        <br><small class="text-muted">{{ Str::limit($t->deskripsi, 60) }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ ucfirst($t->kategori) }}</span></td>
                    <td>{{ $t->labelKesulitan() }}</td>
                    <td>
                        @if($t->link_video_referensi)
                        <a href="{{ $t->link_video_referensi }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-play-circle"></i></a>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.delete-tarian', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tarian ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $t->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('admin.update-tarian', $t->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit: {{ $t->nama_tarian }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label fw-semibold">Nama Tarian</label><input type="text" name="nama_tarian" class="form-control" value="{{ $t->nama_tarian }}" required></div>
                                        <div class="col-md-3"><label class="form-label fw-semibold">Kategori</label><select name="kategori" class="form-select" required>
                                                <option value="tari" {{ $t->kategori == 'tari' ? 'selected' : '' }}>Tari</option>
                                                <option value="musik" {{ $t->kategori == 'musik' ? 'selected' : '' }}>Musik</option>
                                                <option value="teater" {{ $t->kategori == 'teater' ? 'selected' : '' }}>Teater</option>
                                            </select></div>
                                        <div class="col-md-3"><label class="form-label fw-semibold">Kesulitan</label><select name="tingkat_kesulitan" class="form-select" required>
                                                <option value="mudah" {{ $t->tingkat_kesulitan == 'mudah' ? 'selected' : '' }}>Mudah</option>
                                                <option value="menengah" {{ $t->tingkat_kesulitan == 'menengah' ? 'selected' : '' }}>Menengah</option>
                                                <option value="sulit" {{ $t->tingkat_kesulitan == 'sulit' ? 'selected' : '' }}>Sulit</option>
                                            </select></div>
                                        <div class="col-12"><label class="form-label fw-semibold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="3" required>{{ $t->deskripsi }}</textarea></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Filosofi Gerakan</label><textarea name="filosofi_gerakan" class="form-control" rows="3">{{ $t->filosofi_gerakan }}</textarea></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Sejarah Singkat</label><textarea name="sejarah_singkat" class="form-control" rows="3">{{ $t->sejarah_singkat }}</textarea></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Link Video</label><input type="url" name="link_video_referensi" class="form-control" value="{{ $t->link_video_referensi }}"></div>
                                        <div class="col-md-6"><label class="form-label fw-semibold">Foto (kosongkan jika tidak ganti)</label><input type="file" name="foto" class="form-control" accept="image/*"></div>
                                    </div>
                                </div>
                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-burgundy">Simpan Perubahan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada data tarian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $tarian->links() }}</div>
</div>
@endsection