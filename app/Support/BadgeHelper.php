<?php

namespace App\Support;

use BackedEnum;

class BadgeHelper
{
    public static function button(?BackedEnum $status): string
    {
        if (!$status) {
            return '-';
        }

        return sprintf(
            '<button type="button" class="btn btn-sm btn-light-%s">%s</button>',
            $status->color(),
            e($status->label())
        );
    }

    public static function booleanButton(?bool $value, string $trueLabel, string $falseLabel): string
    {
        return sprintf(
            '<button type="button" class="btn btn-sm btn-light-%s">%s</button>',
            $value ? 'success' : 'danger',
            e($value ? $trueLabel : $falseLabel)
        );
    }
}
