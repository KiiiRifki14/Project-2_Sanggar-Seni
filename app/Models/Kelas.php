<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Kelas extends Model
{
    use SoftDeletes, LogsActivity; // ★ Audit Trail

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
            'biaya'     => 'decimal:2',
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
