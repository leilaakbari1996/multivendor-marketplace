<?php

namespace App\Support\Collection;

use ArrayAccess;
use Illuminate\Support\Collection;

class ContactBoxes
{
    /**
     * باکس‌های اطلاعات تماس را از تنظیمات سایت می‌سازد.
     * باکسی که داده‌اش خالی باشد حذف می‌شود.
     *
     * @param  array|ArrayAccess  $settings
     * @return Collection<int, array<string, mixed>>
     */
    public static function make(array|ArrayAccess $settings): Collection
    {
        return collect([
            [
                'icon'  => 'bi-telephone',
                'title' => 'تلفن پشتیبانی',
                'tel'   => $settings['support_phone'] ?? null,
                'note'  => $settings['contact_hours'] ?? null,
            ],
            [
                'icon'  => 'bi-envelope',
                'title' => 'ایمیل',
                'mail'  => $settings['contact_email'] ?? null,
                'note'  => 'پاسخ در کمتر از ۲۴ ساعت',
            ],
            [
                'icon'  => 'bi-geo-alt',
                'title' => 'آدرس فروشگاه',
                'value' => $settings['contact_address'] ?? null,
            ],
        ])
            ->filter(fn (array $box) => filled($box['tel'] ?? $box['mail'] ?? $box['value'] ?? null))
            ->values();
    }
}
