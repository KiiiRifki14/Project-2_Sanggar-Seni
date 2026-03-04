<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Negosiasi extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'tanggal',
        'harga_penawaran',
        'pihak',
        'catatan',
        'is_deal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'          => 'date',
            'harga_penawaran'  => 'decimal:2',
            'is_deal'          => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function labelPihak(): string
    {
        return $this->pihak === 'klien' ? '👤 Klien' : '🏠 Sanggar';
    }

    public function scopeDeals($query)
    {
        return $query->where('is_deal', true);
    }
}
