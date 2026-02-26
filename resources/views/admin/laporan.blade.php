@extends('layouts.admin')
@section('title', 'Laporan & Rekap — Art-Hub')
@section('page-title', 'Laporan & Rekapitulasi')

@section('content')
{{-- Filter --}}
<div class="glass-card p-4 mb-4 animate-fade-up">
    <form method="GET" action="{{ route('admin.laporan') }}" class="form-arthub">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select class="form-select" name="bulan">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                        </option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select class="form-select" name="tahun">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-burgundy w-100"><i class="bi bi-search me-1"></i> Tampilkan</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.export-laporan', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="btn btn-gold w-100">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Summary Stats --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 animate-fade-up delay-1">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#D4EDDA,#C3E6CB);color:#155724;">
                <i class="bi bi-person-plus"></i>
            </div>
            <div class="stat-number">{{ $pendaftaranBulanIni }}</div>
            <div class="stat-label">Pendaftaran Les Bulan Ini</div>
        </div>
    </div>
    <div class="col-md-6 animate-fade-up delay-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#D6EAF8,#AED6F1);color:#2980B9;">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-number">{{ $bookingBulanIni }}</div>
            <div class="stat-label">Booking Pentas Bulan Ini</div>
        </div>
    </div>
</div>

{{-- Rekap Siswa Aktif --}}
<div class="glass-card p-4 mb-4 animate-fade-up delay-2">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-people me-2"></i>Rekap Siswa Diterima</h6>
    @if($siswaAktif->count() > 0)
    <div class="table-responsive">
        <table class="table table-arthub mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Sekolah</th>
                    <th>Orang Tua</th>
                    <th>Tgl Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswaAktif as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $s->user->name }}</strong></td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->asal_sekolah }}</td>
                    <td>{{ $s->nama_orang_tua }}</td>
                    <td>{{ $s->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted small mb-0">Tidak ada data siswa untuk periode ini.</p>
    @endif
</div>

{{-- Rekap Jadwal Pentas --}}
<div class="glass-card p-4 animate-fade-up delay-3">
    <h6 class="fw-bold mb-3" style="color:var(--burgundy-700);"><i class="bi bi-calendar3 me-2"></i>Rekap Jadwal Pementasan</h6>
    @if($jadwalPentas->count() > 0)
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
                </tr>
            </thead>
            <tbody>
                @foreach($jadwalPentas as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $j->user->name }}</strong></td>
                    <td>{{ ucfirst($j->jenis_acara) }}</td>
                    <td>{{ $j->tanggal_pentas->format('d M Y') }}</td>
                    <td>{{ $j->waktu_mulai }} — {{ $j->waktu_selesai }}</td>
                    <td>{{ Str::limit($j->lokasi_acara, 40) }}</td>
                    <td>{{ $j->durasi_jam }} jam</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-muted small mb-0">Tidak ada jadwal pementasan untuk periode ini.</p>
    @endif
</div>
@endsection