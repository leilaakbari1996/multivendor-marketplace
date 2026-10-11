<?php

namespace App\Enums;

enum ContactSubject: string
{
    case ORDER_TRACKING = 'order_tracking';
    case COMPLAINT = 'complaint';
    case SUGGESTION = 'suggestion';
    case COOPERATION = 'cooperation';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::ORDER_TRACKING => 'پیگیری سفارش',
            self::COMPLAINT => 'انتقاد یا شکایت',
            self::SUGGESTION => 'پیشنهاد',
            self::COOPERATION => 'همکاری و فروشندگی',
            self::OTHER => 'سایر',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ORDER_TRACKING => 'info',
            self::COMPLAINT => 'danger',
            self::SUGGESTION => 'success',
            self::COOPERATION => 'primary',
            self::OTHER => 'secondary',
        };
    }

    public function isOrderTracking(): bool
    {
        return $this === self::ORDER_TRACKING;
    }

    public function isComplaint(): bool
    {
        return $this === self::COMPLAINT;
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
