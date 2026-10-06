<?php

namespace App\Queries;
use App\Models\IranProvince;
use Illuminate\Support\Collection;

class ProvinceQuery
{
    public function getForSelect(): Collection
    {
        return IranProvince::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);
    }
}
