<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MenuLocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'url',
        'location',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'location' => MenuLocation::class,
            'parent_id' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    /**
     * @return HasMany<Menu, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsTo<Menu, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    // Scopes

    /**
     * @param Builder<Menu> $query
     * @return Builder<Menu>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param Builder<Menu> $query
     * @return Builder<Menu>
     */
    public function scopeAtLocation(
        Builder $query,
        MenuLocation $location,
    ): Builder {
        return $query->where('location', $location);
    }

    /**
     * @param Builder<Menu> $query
     * @return Builder<Menu>
     */
    public function scopeRootMenus(Builder $query): Builder
    {
        return $query
            ->whereNull('parent_id')
            ->ordered();
    }

    /**
     * @param Builder<Menu> $query
     * @return Builder<Menu>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * @param Builder<Menu> $query
     * @return Builder<Menu>
     */
    public function scopeByLocation(
        Builder $query,
        MenuLocation $location,
    ): Builder {
        return $query
            ->active()
            ->atLocation($location)
            ->rootMenus()
            ->with([
                'children' => fn (Builder $query): Builder => $query
                    ->active()
                    ->ordered(),
            ]);
    }

    /**
     * @param Builder<Menu> $query
     * @param array<MenuLocation> $locations
     * @return Builder<Menu>
     */
    public function scopeByLocations(
        Builder $query,
        array $locations,
    ): Builder {
        return $query
            ->active()
            ->whereIn(
                'location',
                array_map(
                    fn (MenuLocation $location): string => $location->value,
                    $locations,
                ),
            )
            ->rootMenus()
            ->with([
                'children' => fn (Builder $query): Builder => $query
                    ->active()
                    ->ordered(),
            ]);
    }

    // Helpers

    public static function rootMenuOptions(
        array $columns = ['id', 'title'],
    ): array {
        return static::query()
            ->rootMenus()
            ->get($columns)
            ->toArray();
    }
}
