<?php

namespace App\Queries;
use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

class CategoryQuery
{
    public function get(CategoryType $type): Collection
    {
        return Category::query()
            ->activeParents()
            ->ofType($type)
            ->with('media')
            ->orderBy('sort_order')
            ->get();
    }

    public static function findBySlug(string $slug): ?Category
    {
        return Category::query()
            ->active()
            ->slug($slug)
            ->first();
    }
}
