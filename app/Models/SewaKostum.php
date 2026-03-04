<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SewaKostum extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'sewa_kostums';

    protected $fillable = [
        'event_id',
        'vendor_id',
        'nama_kostum',
        'jumlah',
        'biaya_sewa',
        'tanggal_ambil',
        'tanggal_kembali',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'biaya_sewa'      => 'decimal:2',
            'tanggal_ambil'   => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function labelStatus(): string
    {
        return match ($this->status) {
            'dipesan'       => '🟡 Dipesan',
            'diambil'       => '🔵 Diambil',
            'dikembalikan'  => '🟢 Dikembalikan',
            'terlambat'     => '🔴 Terlambat',
            default         => $this->status,
        };
    }

    /**
     * Check if the return deadline is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->tanggal_kembali
            && now()->greaterThan($this->tanggal_kembali)
            && $this->status !== 'dikembalikan';
    }
}
