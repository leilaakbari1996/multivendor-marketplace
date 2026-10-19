<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasMedia;
use App\Enums\BannerPosition;
use App\Traits\InteractsWithMedia;
use App\Traits\PrunesSoftDeleted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory;
    use InteractsWithMedia;
    use PrunesSoftDeleted;
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
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @param  Builder<Banner>  $query
     * @return Builder<Banner>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Banner>  $query
     * @return Builder<Banner>
     */
    public function scopeAtPosition(Builder $query, BannerPosition $position): Builder
    {
        return $query->where('position', $position);
    }

    /**
     * @param  Builder<Banner>  $query
     * @return Builder<Banner>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
