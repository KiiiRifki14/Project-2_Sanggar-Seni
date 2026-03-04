<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'event_id',
        'judul',
        'track',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'catatan',
        'is_merge_point',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'        => 'date',
            'is_merge_point' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    /* ── Label Helpers ── */

    public function labelTrack(): string
    {
        return match ($this->track) {
            'penari'   => '💃 Track Penari',
            'pemusik'  => '🎵 Track Pemusik',
            'gabungan' => '🤝 Latihan Gabungan',
            default    => $this->track,
        };
    }

    /* ── Scopes ── */

    public function scopeMergePoints($query)
    {
        return $query->where('is_merge_point', true);
    }

    public function scopeForTrack($query, string $track)
    {
        if ($track === 'gabungan') {
            return $query; // Show all for merge
        }
        return $query->whereIn('track', [$track, 'gabungan']);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai');
    }
}
