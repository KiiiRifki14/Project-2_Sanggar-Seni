<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservasiPentas extends Model
{
    protected $table = 'reservasi_pentas';

    protected $fillable = [
        'user_id',
        'jenis_acara',
        'tanggal_pentas',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_jam',
        'lokasi_acara',
        'deskripsi_acara',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pentas' => 'date',
            'durasi_jam' => 'decimal:1',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
