<?php

namespace App\Enums;

enum BookingStatus: string
{
    case MENUNGGU  = 'menunggu';
    case DISETUJUI = 'disetujui';
    case DITOLAK   = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU  => 'Menunggu',
            self::DISETUJUI => 'Disetujui',
            self::DITOLAK   => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return 'badge-' . $this->value;
    }
}
