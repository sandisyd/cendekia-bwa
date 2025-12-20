<?php


namespace App\Enums;
enum ReturnBookStatus: string
{
    case RETURNED = 'Dikembalikan';
    case CHECKED = 'Pengecekan';
    case FINE = 'Denda';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->label
        ])->values()->toArray();
    }
}