@extends('layouts.admin')
@section('title', 'Kelola Dokumentasi — Art-Hub')
@section('page-title', 'Log Preservasi — Kelola Dokumentasi')

@section('content')
{{-- Form Upload Dokumentasi --}}
<div class="glass-card p-4 mb-4 animate-fade-up delay-1">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-cloud-upload me-2"></i>Unggah Dokumentasi Baru</h6>
    <form action="{{ route('admin.store-dokumentasi') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                @error('judul')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Jenis Acara <span class="text-danger">*</span></label>
                <select name="jenis_acara" class="form-select" required>
                    <option value="upacara_adat" {{ old('jenis_acara') == 'upacara_adat' ? 'selected' : '' }}>🏛️ Upacara Adat</option>
                    <option value="festival" {{ old('jenis_acara') == 'festival' ? 'selected' : '' }}>🎪 Festival</option>
                    <option value="penyambutan_tamu" {{ old('jenis_acara') == 'penyambutan_tamu' ? 'selected' : '' }}>🤝 Penyambutan Tamu</option>
                    <option value="lainnya" {{ old('jenis_acara') == 'lainnya' ? 'selected' : '' }}>📁 Lainnya</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">File (Foto/Video) <span class="text-danger">*</span></label>
                <input type="file" name="file" class="form-control" accept="image/*,video/*" required>
                <small class="text-muted">Maks. 50 MB. Format: JPG, PNG, MP4, MOV, AVI</small>
            </div>
        </div>
        <button type="submit" class="btn btn-burgundy mt-3"><i class="bi bi-cloud-upload me-2"></i>Unggah Dokumentasi</button>
    </form>
</div>

{{-- Daftar Dokumentasi --}}
<div class="glass-card p-4 animate-fade-up delay-2">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-camera-video me-2"></i>Arsip Dokumentasi ({{ $dokumentasi->total() }})</h6>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th>Judul</th>
                    <th>Jenis Acara</th>
                    <th>Tahun</th>
                    <th>Tipe</th>
                    <th style="width:10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokumentasi as $idx => $d)
                <tr>
                    <td>{{ $dokumentasi->firstItem() + $idx }}</td>
                    <td>
                        <strong>{{ $d->judul }}</strong>
                        <br><small class="text-muted">{{ Str::limit($d->deskripsi, 60) }}</small>
                    </td>
                    <td><span class="badge bg-info text-dark">{{ $d->labelJenisAcara() }}</span></td>
                    <td>{{ $d->tahun }}</td>
                    <td>
                        @if($d->tipe === 'video')
                        <span class="badge bg-danger"><i class="bi bi-play-circle me-1"></i>Video</span>
                        @else
                        <span class="badge bg-success"><i class="bi bi-image me-1"></i>Foto</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.delete-dokumentasi', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus dokumentasi ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Belum ada dokumentasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $dokumentasi->links() }}</div>
</div>
@endsection