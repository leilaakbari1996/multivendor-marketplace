<?php

namespace App\Enums;

enum MenuLocation: string
{
    case HEADER = 'header';
    case FOOTER = 'footer';

    public function label(): string
    {
        return match ($this) {
            self::HEADER => 'هدر',
            self::FOOTER => 'فوتر',
        };
    }
}
