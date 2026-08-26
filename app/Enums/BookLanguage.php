<?php


namespace App\Enums;
enum BookLanguage: string
{
    case ENGLISH = 'English';
    case SPANISH = 'Spain';
    case FRENCH = 'Franch';
    case GERMAN = 'Germany';
    case CHINESE = 'China';
    case INDONESIAN = 'Indonesia';
    case JAPANESE = 'Jepang';
    case RUSSIAN = 'Rusia';
    case ARABIC = 'Arab';
    case HINDI = 'India';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->name
        ])->values()->toArray();
    }
}

