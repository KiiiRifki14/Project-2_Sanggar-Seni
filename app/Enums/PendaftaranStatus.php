<?php

namespace App\Enums;

enum PendaftaranStatus: string
{
    case MENUNGGU = 'menunggu';
    case DITERIMA = 'diterima';
    case DITOLAK  = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::DITERIMA => 'Diterima',
            self::DITOLAK  => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return 'badge-' . $this->value;
    }
}
