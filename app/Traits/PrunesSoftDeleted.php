<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

/**
 * Permanently deletes soft-deleted records after a retention period.
 * Use it together with SoftDeletes.
 */
trait PrunesSoftDeleted
{
    use Prunable;

    /**
     * @return Builder<static>
     */
    public function prunable(): Builder
    {
        return static::onlyTrashed()->where(
            $this->getQualifiedDeletedAtColumn(),
            '<=',
            now()->subDays($this->pruneAfterDays()),
        );
    }

    /**
     * Override this in a model to change the retention period.
     */
    protected function pruneAfterDays(): int
    {
        return 30;
    }
}
