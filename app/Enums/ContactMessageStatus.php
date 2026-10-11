<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case NEW = 'new';
    case READ = 'read';
    case REPLIED = 'replied';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'جدید',
            self::READ => 'خوانده‌شده',
            self::REPLIED => 'پاسخ داده‌شده',
            self::ARCHIVED => 'بایگانی',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'warning',
            self::READ => 'info',
            self::REPLIED => 'success',
            self::ARCHIVED => 'secondary',
        };
    }

    public function isNew(): bool
    {
        return $this === self::NEW;
    }

    public function isReplied(): bool
    {
        return $this === self::REPLIED;
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
