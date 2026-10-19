<?php

declare(strict_types=1);

namespace App\Enums;

enum BannerPosition: string
{
    case MAIN = 'main';
    case PROMO = 'promo';
    case SIDE_TOP = 'side_top';
    case SIDE_BOTTOM = 'side_bottom';

    public function label(): string
    {
        return __('banner.positions.'.$this->value);
    }

    /**
     * Options for select inputs: [value => translated label].
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
