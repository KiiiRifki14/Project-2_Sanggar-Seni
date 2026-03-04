<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personel extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'peran',
        'no_whatsapp',
        'alamat',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function labelPeran(): string
    {
        return $this->peran === 'penari' ? '💃 Penari' : '🎵 Pemusik';
    }

    public function labelGender(): string
    {
        return $this->jenis_kelamin === 'L' ? '♂ Putra' : '♀ Putri';
    }
}
