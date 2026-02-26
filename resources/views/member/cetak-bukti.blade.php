<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran — Art-Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body {
            background: white;
        }

        .bukti-container {
            max-width: 700px;
            margin: 2rem auto;
            border: 2px solid var(--burgundy-700);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .bukti-header {
            background: linear-gradient(135deg, var(--burgundy-800), var(--burgundy-600));
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }

        .bukti-body {
            padding: 2rem;
        }

        .bukti-row {
            display: flex;
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--cream-300);
        }

        .bukti-label {
            width: 180px;
            font-weight: 600;
            color: var(--dark-900);
            font-size: 0.9rem;
        }

        .bukti-value {
            flex: 1;
            color: #444;
            font-size: 0.9rem;
        }

        .bukti-footer {
            background: var(--cream-200);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.8rem;
            color: #666;
        }

        .ref-number {
            font-family: monospace;
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--burgundy-700);
            letter-spacing: 2px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .bukti-container {
                border: 2px solid #333;
            }
        }
    </style>
</head>

<body>
    <div class="text-center mt-3 no-print">
        <button onclick="window.print()" class="btn btn-burgundy"><i class="bi bi-printer me-1"></i> Cetak / Simpan PDF</button>
        <a href="{{ route('member.riwayat') }}" class="btn btn-outline-secondary ms-2">Kembali</a>
    </div>

    <div class="bukti-container">
        <div class="bukti-header">
            <h4 style="font-family:var(--font-heading);margin:0;">🎭 Art-Hub Sanggar Seni</h4>
            <small>Bukti Pendaftaran Les Seni</small>
        </div>
        <div class="bukti-body">
            <div class="text-center mb-3">
                <span class="ref-number">REF# AH-{{ str_pad($pendaftaran->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="bukti-row">
                <div class="bukti-label">Nama Murid</div>
                <div class="bukti-value">{{ $pendaftaran->user->name }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Email</div>
                <div class="bukti-value">{{ $pendaftaran->user->email }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">No. WhatsApp</div>
                <div class="bukti-value">{{ $pendaftaran->user->no_whatsapp }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Tempat, Tgl Lahir</div>
                <div class="bukti-value">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d F Y') }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Asal Sekolah</div>
                <div class="bukti-value">{{ $pendaftaran->asal_sekolah }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Nama Orang Tua</div>
                <div class="bukti-value">{{ $pendaftaran->nama_orang_tua }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">No. HP Orang Tua</div>
                <div class="bukti-value">{{ $pendaftaran->no_hp_ortu }}</div>
            </div>

            <hr class="my-3">

            <div class="bukti-row">
                <div class="bukti-label">Kelas</div>
                <div class="bukti-value fw-bold" style="color:var(--burgundy-700);">{{ $pendaftaran->kelas->nama_kelas }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Kategori</div>
                <div class="bukti-value">{{ ucfirst($pendaftaran->kelas->kategori) }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Jadwal</div>
                <div class="bukti-value">{{ $pendaftaran->kelas->jadwal }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Biaya / Bulan</div>
                <div class="bukti-value">Rp {{ number_format($pendaftaran->kelas->biaya, 0, ',', '.') }}</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Tanggal Daftar</div>
                <div class="bukti-value">{{ $pendaftaran->created_at->format('d F Y, H:i') }} WIB</div>
            </div>
            <div class="bukti-row">
                <div class="bukti-label">Status</div>
                <div class="bukti-value">
                    <span class="badge-{{ $pendaftaran->status->value }}">{{ $pendaftaran->status->label() }}</span>
                </div>
            </div>
        </div>
        <div class="bukti-footer">
            Dokumen ini dicetak secara digital oleh sistem Art-Hub.<br>
            Berlaku sebagai bukti pendaftaran resmi. Harap dibawa saat latihan pertama.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>