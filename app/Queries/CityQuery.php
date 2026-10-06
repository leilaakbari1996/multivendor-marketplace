<?php

namespace App\Queries;

use App\Models\IranCity;
use Illuminate\Database\Eloquent\Collection;

class CityQuery
{
    public function getBySector(int $sectorId): Collection
    {
        return IranCity::query()
            ->forSector($sectorId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
