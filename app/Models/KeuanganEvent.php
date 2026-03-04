<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeuanganEvent extends Model
{
    use HasUuids;

    protected $table = 'keuangan_events';

    protected $fillable = [
        'event_id',
        'harga_deal',
        'estimasi_konsumsi',
        'estimasi_transport',
        'estimasi_sewa_kostum',
        'estimasi_honor',
        'real_konsumsi',
        'real_transport',
        'real_sewa_kostum',
        'real_honor',
    ];

    protected function casts(): array
    {
        return [
            'harga_deal'          => 'decimal:2',
            'estimasi_konsumsi'   => 'decimal:2',
            'estimasi_transport'  => 'decimal:2',
            'estimasi_sewa_kostum' => 'decimal:2',
            'estimasi_honor'      => 'decimal:2',
            'real_konsumsi'       => 'decimal:2',
            'real_transport'      => 'decimal:2',
            'real_sewa_kostum'    => 'decimal:2',
            'real_honor'          => 'decimal:2',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /* ── Computed Accessors ── */

    public function getEstimasiTotalAttribute(): float
    {
        return $this->estimasi_konsumsi
            + $this->estimasi_transport
            + $this->estimasi_sewa_kostum
            + $this->estimasi_honor;
    }

    public function getRealTotalAttribute(): float
    {
        return $this->real_konsumsi
            + $this->real_transport
            + $this->real_sewa_kostum
            + $this->real_honor;
    }

    /**
     * Laba Bersih (Estimasi) = Harga Deal - Total Estimasi Biaya
     */
    public function getEstimasiLabaAttribute(): float
    {
        return $this->harga_deal - $this->estimasi_total;
    }

    /**
     * Laba Bersih (Realisasi) = Harga Deal - Total Biaya Riil
     */
    public function getRealLabaAttribute(): float
    {
        return $this->harga_deal - $this->real_total;
    }

    /**
     * Selisih antara estimasi dan realita (positif = hemat, negatif = boros).
     */
    public function getSelisihAttribute(): float
    {
        return $this->real_laba - $this->estimasi_laba;
    }
}
