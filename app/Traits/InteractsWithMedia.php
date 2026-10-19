<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\MediaCollection;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractsWithMedia
{
    /**
     * Runs automatically for every model that uses this trait.
     */
    protected static function bootInteractsWithMedia(): void
    {
        static::deleted(function (Model $model): void {
            // A soft delete keeps the record, so keep its media too.
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            // Delete one by one so the Media "deleted" event removes each file.
            $model->media->each->delete();
        });
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    /**
     * URL of the first media in a collection.
     * Eager load with with('media') in lists to avoid N+1 queries.
     */
    public function getFirstMediaUrl(MediaCollection $collection, string $default = ''): string
    {
        $media = $this->media->firstWhere('collection', $collection);

        return $media?->url ?? $default;
    }
}
