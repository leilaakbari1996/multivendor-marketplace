<?php

namespace App\Queries;

use App\Models\IranSector;
use Illuminate\Database\Eloquent\Collection;

class SectorQuery
{
    public function getByCounty(int $countyId): Collection
    {
        return IranSector::query()
            ->forCounty($countyId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
