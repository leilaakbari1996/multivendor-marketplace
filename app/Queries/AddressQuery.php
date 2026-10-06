<?php

namespace App\Queries;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressQuery
{
    public function forUser(int $userId): Collection
    {
        return Address::query()
            ->forUser($userId)
            ->defaultFirst()
            ->get();
    }
}
