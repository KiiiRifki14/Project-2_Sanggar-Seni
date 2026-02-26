@extends('layouts.admin')
@section('title', 'Kelola Galeri — Art-Hub')
@section('page-title', 'Kelola Galeri')

@section('content')
{{-- Upload Form --}}
<div class="glass-card p-4 mb-4 animate-fade-up">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-cloud-upload me-2"></i>Unggah Konten Baru</h6>
    <form action="{{ route('admin.store-galeri') }}" method="POST" enctype="multipart/form-data" class="form-arthub">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" required placeholder="Judul konten">
                @error('judul')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipe</label>
                <select class="form-select" name="tipe" required>
                    <option value="foto">📷 Foto</option>
                    <option value="video">🎬 Video</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">File</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" accept="image/*,video/*" required>
                @error('file')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-gold w-100"><i class="bi bi-upload me-1"></i> Upload</button>
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi (opsional)</label>
                <input type="text" class="form-control" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Deskripsi singkat...">
            </div>
        </div>
    </form>
</div>

{{-- Gallery Grid --}}
<div class="glass-card p-4 animate-fade-up delay-2">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-images me-2"></i>Daftar Galeri ({{ $galeri->total() }} item)</h6>

    @if($galeri->count() > 0)
    <div class="row g-3">
        @foreach($galeri as $g)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="gallery-item position-relative" style="border-radius:var(--radius-md);overflow:hidden;">
                @if($g->tipe === 'foto')
                <img src="{{ asset($g->file_path) }}" alt="{{ $g->judul }}" style="width:100%;height:180px;object-fit:cover;">
                @else
                <div style="width:100%;height:180px;background:var(--dark-900);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-play-circle-fill text-white" style="font-size:2.5rem;opacity:0.7;"></i>
                </div>
                @endif
                <div class="p-2 bg-white">
                    <small class="fw-bold d-block text-truncate">{{ $g->judul }}</small>
                    <small class="text-muted">{{ $g->created_at->format('d M Y') }}</small>
                    <form action="{{ route('admin.delete-galeri', $g->id) }}" method="POST" class="mt-1" onsubmit="return confirm('Hapus item ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100"><i class="bi bi-trash me-1"></i>Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $galeri->links() }}</div>
    @else
    <div class="text-center py-4 text-muted">
        <i class="bi bi-images fs-2 d-block mb-2"></i>
        <p class="small">Belum ada konten galeri. Mulai unggah foto/video di atas.</p>
    </div>
    @endif
</div>
@endsection