<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Galeri extends Model
{
    use HasUuids, SoftDeletes, LogsActivity; // ★ UUID + SoftDeletes + Audit Trail

    protected $fillable = [
        'judul',
        'deskripsi',
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
}
