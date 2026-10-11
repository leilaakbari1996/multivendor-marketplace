<?php

namespace App\Enums;

enum Page: string
{
    case HOME = 'home';
    case ABOUT = 'about';
    case CONTACT = 'contact';
    case ALL = 'all';

    public function label(): string
    {
        return match ($this) {
            self::HOME => 'صفحه اصلی',
            self::ABOUT => 'درباره ما',
            self::CONTACT => 'تماس با ما',
            self::ALL => 'همه',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $page) => [
                $page->value => $page->label(),
            ])
            ->toArray();
    }
}
