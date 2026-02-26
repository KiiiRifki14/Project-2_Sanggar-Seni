<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kategori',
        'deskripsi',
        'jadwal',
        'biaya',
        'kuota',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'biaya' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranLes::class);
    }

    public function siswaAktif()
    {
        return $this->hasMany(PendaftaranLes::class)->where('status', 'diterima');
    }
}
