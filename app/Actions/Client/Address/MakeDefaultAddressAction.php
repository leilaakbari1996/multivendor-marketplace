<?php

namespace App\Actions\Client\Address;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class MakeDefaultAddressAction
{
    public function execute(Address $address): Address
    {
        return DB::transaction(function () use ($address) {
            Address::query()
                ->forUser($address->user_id)
                ->whereKeyNot($address->id)
                ->update([
                    'is_default' => false,
                ]);

            $address->update([
                'is_default' => true,
            ]);

            return $address->fresh();
        });
    }
}
