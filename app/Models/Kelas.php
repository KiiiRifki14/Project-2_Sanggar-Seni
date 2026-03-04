<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\LogsActivity;

class Kelas extends Model
{
    use HasUuids, SoftDeletes, LogsActivity;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_tarian',
        'kategori',
        'deskripsi',
        'filosofi_gerakan',
        'sejarah_singkat',
        'link_video_referensi',
        'tingkat_kesulitan',
        'foto_path',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function labelKesulitan(): string
    {
        return match ($this->tingkat_kesulitan) {
            'mudah'    => '🟢 Mudah',
            'menengah' => '🟡 Menengah',
            'sulit'    => '🔴 Sulit',
            default    => $this->tingkat_kesulitan,
        };
    }
}
