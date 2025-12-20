<?php


namespace App\Enums;
enum ReturnBookCondition: string
{
    case GOOD = 'Baik';
    case DAMAGED = 'Rusak';
    case LOST = 'Hilang';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->value
        ])->values()->toArray();
    }
}