<?php

namespace App\Actions\Client\Address;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UpdateAddressAction
{
    public function execute(
        Address $address,
        array $data
    ): Address {
        return DB::transaction(function () use ($address, $data) {

            $isDefault = $data['is_default'] ?? false;

            if ($isDefault) {
                Address::query()
                    ->forUser($address->user_id)
                    ->whereKeyNot($address->id)
                    ->update([
                        'is_default' => false,
                    ]);
            }

            $address->update([
                ...$data,
                'is_default' => $isDefault,
            ]);

            return $address->fresh();
        });
    }
}
