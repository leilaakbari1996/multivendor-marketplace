<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * Implemented by enums that are displayed as a colored badge.
 */
interface HasBadge
{
    /** Human-readable (translated) text of the badge. */
    public function label(): string;

    /** Template color name: success, danger, warning, info, primary, secondary... */
    public function color(): string;
}
