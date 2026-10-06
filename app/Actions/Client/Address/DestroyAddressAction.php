<?php

namespace App\Actions\Client\Address;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class DestroyAddressAction
{
    public function execute(Address $address): void
    {
        DB::transaction(function () use ($address) {
            $wasDefault = $address->is_default;

            $address->delete();

            if ($wasDefault) {
                Address::query()
                    ->forUser($address->user_id)
                    ->latest('id')
                    ->first()
                    ?->update([
                        'is_default' => true,
                    ]);
            }
        });
    }
}
