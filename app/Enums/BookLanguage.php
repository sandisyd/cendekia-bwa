<?php


namespace App\Enums;
enum BookLanguage: string
{
    case ENGLISH = 'en';
    case SPANISH = 'es';
    case FRENCH = 'fr';
    case GERMAN = 'de';
    case CHINESE = 'ch';
    case INDONESIAN = 'id';
    case JAPANESE = 'jp';
    case RUSSIAN = 'ru';
    case ARABIC = 'ar';
    case HINDI = 'hi';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->name
        ])->values()->toArray();
    }
}

