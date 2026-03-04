<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'nama_event',
        'jenis_acara',
        'klien',
        'lokasi',
        'tanggal_event',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'status_bayar',
        'nominal_dp',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_event' => 'date',
            'nominal_dp'    => 'decimal:2',
        ];
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function sewaKostums(): HasMany
    {
        return $this->hasMany(SewaKostum::class);
    }

    public function negosiasis(): HasMany
    {
        return $this->hasMany(Negosiasi::class);
    }

    public function keuangan(): HasOne
    {
        return $this->hasOne(KeuanganEvent::class);
    }

    /* ── Label Helpers ── */

    public function labelStatus(): string
    {
        return match ($this->status) {
            'persiapan'   => '🟡 Persiapan',
            'berlangsung' => '🔵 Berlangsung',
            'selesai'     => '🟢 Selesai',
            'batal'       => '🔴 Batal',
            default       => $this->status,
        };
    }

    public function labelBayar(): string
    {
        return match ($this->status_bayar) {
            'belum_dp' => '🔴 Belum DP',
            'sudah_dp' => '🟡 Sudah DP',
            'lunas'    => '🟢 Lunas',
            default    => $this->status_bayar,
        };
    }

    public function labelJenis(): string
    {
        return match ($this->jenis_acara) {
            'pernikahan'  => '💒 Pernikahan',
            'festival'    => '🎪 Festival',
            'penyambutan' => '🤝 Penyambutan',
            'budaya'      => '🎭 Budaya',
            'lainnya'     => '📌 Lainnya',
            default       => $this->jenis_acara,
        };
    }

    /* ── Scopes ── */

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['persiapan', 'berlangsung']);
    }

    /**
     * Get the deal price from negosiasi (the one marked is_deal).
     */
    public function getHargaDealAttribute(): float
    {
        $deal = $this->negosiasis()->where('is_deal', true)->first();
        return $deal ? (float) $deal->harga_penawaran : 0;
    }
}
