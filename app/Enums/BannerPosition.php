<?php

namespace App\Enums;

enum BannerPosition: string
{
    case MAIN = 'main';
    case PROMO = 'promo';
    case SIDE_TOP = 'side_top';
    case SIDE_BOTTOM = 'side_bottom';

    public function label(): string
    {
        return match ($this) {
            self::MAIN => 'اسلایدر اصلی',
            self::SIDE_TOP => 'بنر کناری بالا',
            self::SIDE_BOTTOM => 'بنر کناری پایین',
            self::PROMO => 'بنر تبلیغاتی صفحه اصلی',
        };
    }
}
