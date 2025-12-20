<?php


namespace App\Enums;
enum BookStatus: string
{
    case AVAILABLE = 'Tersedia';
    case LOAN = 'Dipinjam';
    case DAMAGED = 'Rusak';
    case LOST = 'Hilang';

    case UNAVAILABLE = 'Tidak Tersedia';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->name
        ])->values()->toArray();
    }
}