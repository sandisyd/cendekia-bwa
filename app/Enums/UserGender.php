<?php


namespace App\Enums;
enum UserGender: string
{
    case MALE = 'Laki-Laki';
    case FEMALE = 'Perempuan';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->label
        ])->values()->toArray();
    }
}