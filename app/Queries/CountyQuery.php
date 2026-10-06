<?php

namespace App\Queries;

use App\Models\IranCounty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CountyQuery
{
    public function getByProvince(int $provinceId): Collection
    {
        return IranCounty::query()
            ->forProvince($provinceId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
