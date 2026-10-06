<?php

namespace App\Enums;

enum CouponType: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public function label(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'درصدی',
            self::FIXED => 'ثابت',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PERCENTAGE => 'info',
            self::FIXED => 'success',
        };
    }

    public function isPercentage(): bool
    {
        return $this === self::PERCENTAGE;
    }

    public function isFixed(): bool
    {
        return $this === self::FIXED;
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
