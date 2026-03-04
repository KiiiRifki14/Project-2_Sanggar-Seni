<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\LogsActivity;

class Kostum extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $table = 'kostums';

    protected $fillable = [
        'nama_kostum',
        'kategori',
        'deskripsi',
        'nama_aksesoris',
        'makna_warna',
        'makna_ornamen',
        'kondisi_fisik',
        'foto_path',
    ];

    public function labelKondisi(): string
    {
        return match ($this->kondisi_fisik) {
            'baik'  => '🟢 Baik',
            'cukup' => '🟡 Cukup',
            'rusak' => '🔴 Rusak',
            default => $this->kondisi_fisik,
        };
    }
}
