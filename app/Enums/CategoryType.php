<?php

declare(strict_types=1);

namespace App\Enums;

enum CategoryType: string
{
    case Product = 'product';
    case Faq = 'faq';
    // case Article = 'article'; // add new types here, plus a key in lang/*/category.php

    public function label(): string
    {
        return __('category.types.'.$this->value);
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
