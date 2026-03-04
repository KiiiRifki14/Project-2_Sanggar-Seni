<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'nama_vendor',
        'kontak',
        'alamat',
        'catatan',
    ];

    public function sewaKostums(): HasMany
    {
        return $this->hasMany(SewaKostum::class);
    }
}
