<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'در انتظار پرداخت',
            self::PROCESSING => 'در حال پردازش',
            self::SHIPPED => 'ارسال شده',
            self::DELIVERED => 'تحویل شده',
            self::CANCELLED => 'لغو شده',
            self::REFUNDED => 'مرجوع شده',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PROCESSING => 'info',
            self::SHIPPED => 'primary',
            self::DELIVERED => 'success',
            self::CANCELLED => 'danger',
            self::REFUNDED => 'secondary',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(
                fn (self $status) => [
                    $status->value => $status->label(),
                ]
            )
            ->toArray();
    }
}
