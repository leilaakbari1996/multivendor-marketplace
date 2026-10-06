<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case VENDOR = 'vendor';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'مدیر',
            self::VENDOR => 'فروشنده',
            self::CUSTOMER => 'مشتری',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type) => [
                $type->value => $type->label(),
            ])
            ->toArray();
    }
}
