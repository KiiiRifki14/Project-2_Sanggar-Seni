<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PendaftaranStatus;

class PendaftaranLes extends Model
{
    use HasUuids, SoftDeletes; // ★ UUID + SoftDeletes

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
            'status'        => PendaftaranStatus::class, // ★ Enum Cast
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
