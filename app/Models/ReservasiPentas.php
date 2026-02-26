<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\BookingStatus;
use App\Traits\LogsActivity;

class ReservasiPentas extends Model
{
    use HasUuids, SoftDeletes, LogsActivity; // ★ UUID + SoftDeletes + Audit Trail


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
            'durasi_jam'     => 'decimal:1',
            'status'         => BookingStatus::class, // ★ Enum Cast
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
