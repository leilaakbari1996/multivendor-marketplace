<?php

namespace App\Models;

use App\Enums\BannerPosition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'url',
        'position',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'position' => BannerPosition::class,
            'is_active' => 'boolean',
        ];
    }

    //region Morphs

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    //endregion

    //region Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAtPosition(
        Builder $query,
        BannerPosition $position
    ): Builder {
        return $query->where('position', $position);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    //endregion
}
