<?php


namespace App\Enums;
enum FinePaymentStatus: string
{
    case PENDING = 'Tertunda';
    case SUCCES = 'Sukses';
    case FAILED = 'Gagal';

    public static function options(): array
    {
        return collect(self::cases())->map(fn($itm)=>[
            'value'=>$itm->value,
            'label'=>$itm->value
        ])->values()->toArray();
    }
}