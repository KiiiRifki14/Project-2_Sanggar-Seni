<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftaranLes extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran_les';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'tempat_lahir',
        'tanggal_lahir',
        'asal_sekolah',
        'nama_orang_tua',
        'no_hp_ortu',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
