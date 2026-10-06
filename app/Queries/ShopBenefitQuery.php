<?php

namespace App\Queries;

use App\Models\ShopBenefit;
use Illuminate\Database\Eloquent\Collection;

class ShopBenefitQuery
{
    public function get(): Collection
    {
        return ShopBenefit::query()
            ->active()
            ->ordered()
            ->get();
    }
}
