<?php

namespace App\Enums;

enum MediaOwnerType: string
{
    case USER = 'user';
    case CATEGORY = 'category';
    case PRODUCT = 'product';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'کاربر',
            self::CATEGORY => 'دسته‌بندی',
            self::PRODUCT => 'محصول',
        };
    }

    public function model(): string
    {
        return match ($this) {
            self::USER => \App\Models\User::class,
            self::CATEGORY => \App\Models\Category::class,
            self::PRODUCT => \App\Models\Product::class,
        };
    }

    public static function fromModel(string $model): ?self
    {
        return match ($model) {
            \App\Models\User::class => self::USER,
            \App\Models\Category::class => self::CATEGORY,
            \App\Models\Product::class => self::PRODUCT,
            default => null,
        };
    }
}
