<?php

namespace App\Support;

use Carbon\CarbonInterface;
use Morilog\Jalali\Jalalian;

class DateHelper
{
    public static function toJalali(
        ?CarbonInterface $date,
        string $format = 'Y/m/d H:i:s'
    ): string {
        if (!$date) {
            return '-';
        }

        return Jalalian::fromCarbon(
            $date->timezone(config('app.timezone'))
        )->format($format);
    }

    public static function toGregorian(
        ?string $date,
        string $format = 'Y/m/d H:i:s'
    ): ?string {
        if (!$date) {
            return null;
        }

        return Jalalian::fromFormat($format, $date)
            ->toCarbon()
            ->format('Y-m-d H:i:s');
    }
}
