<?php

namespace App\Queries;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

class CategoryQuery
{
    public function get(): Collection
    {
        return Category::query()
            ->activeParents()
            ->with('media')
            ->orderBy('sort_order')
            ->get();
    }
}
