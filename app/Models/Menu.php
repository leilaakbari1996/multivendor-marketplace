<?php

namespace App\Models;

use App\Enums\MenuLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
            'is_active' => 'boolean',
        ];
    }

    //region Relationships

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    //endregion

    //region Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeAtLocation($query, MenuLocation $location)
    {
        return $query->where('location', $location);
    }
    public function scopeRootMenus($query)
    {
        return $query
            ->whereNull('parent_id')
            ->orderBy('sort_order');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    // App\Models\Menu.php

    public function scopeByLocation($query, MenuLocation $location)
    {
        return $query
            ->active()
            ->where('location', $location->value)
            ->whereNull('parent_id')
            ->ordered()
            ->with([
                'children' => fn ($query) => $query
                    ->active()
                    ->ordered()
            ]);
    }

    public function scopeByLocations(Builder $query, array $locations): Builder
    {
        return $query
            ->active()
            ->whereIn(
                'location',
                array_map(
                    fn (MenuLocation $location) => $location->value,
                    $locations
                )
            )
            ->whereNull('parent_id')
            ->ordered()
            ->with([
                'children' => fn ($query) => $query
                    ->active()
                    ->ordered()
            ]);
    }

    //endregion

    public static function rootMenuOptions(array $columns = ['id', 'title']): array
    {
        return static::query()
            ->rootMenus()
            ->get($columns)
//            ->pluck('title', 'id')
            ->toArray();
    }


}
