<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\LogsActivity;

class Dokumentasi extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $table = 'dokumentasis';

    protected $fillable = [
        'judul',
        'deskripsi',
        'jenis_acara',
        'tahun',
        'file_path',
        'tipe',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function labelJenisAcara(): string
    {
        return match ($this->jenis_acara) {
            'upacara_adat'     => 'Upacara Adat',
            'festival'         => 'Festival',
            'penyambutan_tamu' => 'Penyambutan Tamu',
            'lainnya'          => 'Lainnya',
            default            => $this->jenis_acara,
        };
    }
}
