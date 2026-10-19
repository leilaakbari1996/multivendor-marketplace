<?php

declare(strict_types=1);

namespace App\Support;

use App\Contracts\HasBadge;

/**
 * Builds the HTML of status badges used in datatables.
 * The result is HTML, so the datatable column must be listed in rawColumns().
 */
final class BadgeHelper
{
    /**
     * Badge for an enum that implements HasBadge.
     */
    public static function button(?HasBadge $status): string
    {
        if ($status === null) {
            return '-';
        }

        return self::render($status->color(), $status->label());
    }

    /**
     * Green/red badge for a boolean value.
     */
    public static function booleanButton(?bool $value, string $trueLabel, string $falseLabel): string
    {
        return self::render(
            $value ? 'success' : 'danger',
            $value ? $trueLabel : $falseLabel,
        );
    }

    private static function render(string $color, string $label): string
    {
        // A badge is not interactive, so a <span> is used instead of a <button>.
        // Both values are escaped, so the output is safe to print raw.
        return sprintf(
            '<span class="badge badge-light-%s">%s</span>',
            e($color),
            e($label),
        );
    }
}
