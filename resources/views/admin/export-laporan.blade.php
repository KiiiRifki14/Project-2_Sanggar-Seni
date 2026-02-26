<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Art-Hub — {{ $namaBulan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body {
            background: white;
            font-size: 0.85rem;
        }

        .report-header {
            background: linear-gradient(135deg, var(--burgundy-800), var(--burgundy-600));
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
        }

        table th {
            background: var(--burgundy-700) !important;
            color: white;
            font-size: 0.8rem;
        }

        table td {
            font-size: 0.82rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .report-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="no-print text-center my-3">
        <button onclick="window.print()" class="btn btn-burgundy"><i class="bi bi-printer me-1"></i> Cetak / Simpan PDF</button>
        <a href="{{ route('admin.laporan') }}" class="btn btn-outline-secondary ms-2">Kembali</a>
    </div>

    <div class="container" style="max-width:900px;">
        <div class="report-header rounded-3">
            <h4 style="font-family:var(--font-heading);margin:0;">🎭 Art-Hub Sanggar Seni</h4>
            <p class="mb-0 mt-1">Laporan Bulanan — {{ $namaBulan }}</p>
        </div>

        {{-- Rekap Siswa --}}
        <h6 class="fw-bold mb-2" style="color:var(--burgundy-700);">A. Rekap Pendaftaran Siswa (Diterima)</h6>
        @if($siswaAktif->count() > 0)
        <table class="table table-bordered table-sm mb-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Asal Sekolah</th>
                    <th>Orang Tua</th>
                    <th>Tgl Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswaAktif as $i => $s)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $s->user->name }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->asal_sekolah }}</td>
                    <td>{{ $s->nama_orang_tua }}</td>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="small text-muted">Total: <strong>{{ $siswaAktif->count() }}</strong> siswa</p>
        @else
        <p class="text-muted small mb-4">Tidak ada data.</p>
        @endif

        {{-- Rekap Pentas --}}
        <h6 class="fw-bold mb-2" style="color:var(--burgundy-700);">B. Rekap Jadwal Pementasan (Disetujui)</h6>
        @if($jadwalPentas->count() > 0)
        <table class="table table-bordered table-sm mb-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Klien</th>
                    <th>Acara</th>
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
                    <td>{{ $j->user->name }}</td>
                    <td>{{ ucfirst($j->jenis_acara) }}</td>
                    <td>{{ $j->tanggal_pentas->format('d/m/Y') }}</td>
                    <td>{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
                    <td>{{ $j->lokasi_acara }}</td>
                    <td>{{ $j->durasi_jam }} jam</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="small text-muted">Total: <strong>{{ $jadwalPentas->count() }}</strong> pementasan</p>
        @else
        <p class="text-muted small mb-4">Tidak ada data.</p>
        @endif

        <hr>
        <div class="text-center small text-muted mt-3">
            Dicetak dari sistem Art-Hub pada {{ now()->format('d F Y, H:i') }} WIB
        </div>
    </div>
</body>

</html>