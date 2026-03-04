<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasUuids;

    protected $fillable = [
        'jadwal_id',
        'personel_id',
        'status',
        'catatan',
    ];

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function personel(): BelongsTo
    {
        return $this->belongsTo(Personel::class);
    }

    public function labelStatus(): string
    {
        return match ($this->status) {
            'hadir' => '🟢 Hadir',
            'izin'  => '🟡 Izin',
            'absen' => '🔴 Absen',
            default => $this->status,
        };
    }
}
