<?php

namespace App\Queries;

use App\Models\IranRuralDistrict;
use Illuminate\Database\Eloquent\Collection;

class DistrictQuery
{
    public function getByCounty(int $countyId): Collection
    {
        return IranRuralDistrict::query()
            ->forCounty($countyId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
