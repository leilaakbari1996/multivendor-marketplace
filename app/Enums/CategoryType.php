<?php

namespace App\Enums;

enum CategoryType: string
{
    case Product = 'product';
    case Faq     = 'faq';
    // case Article = 'article';   // بعداً هر نوع دیگری که خواستید

    public function label(): string
    {
        return match ($this) {
            self::Product => 'محصولات',
            self::Faq     => 'سوالات متداول',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $t) => [$t->value => $t->label()])
            ->all();
    }
}
