<?php

namespace App\Actions\Client\Address;

use App\Constants\AddressConstant;
use App\Exceptions\Address\AddressLimitExceededException;
use App\Models\Address;
use App\Support\AuthUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StoreAddressAction
{
    public function execute(array $data): Address
    {
        return DB::transaction(function () use ($data) {
            $user = AuthUser::user();

            $this->ensureAddressLimit($user->id);

            $isFirstAddress = ! $user->addresses()->exists();

            $isDefault = $isFirstAddress || ($data['is_default'] ?? false);

            if ($isDefault) {
                $user->addresses()->update([
                    'is_default' => false,
                ]);
            }

            return $user->addresses()->create([
                ...$data,
                'is_default' => $isDefault,
            ]);
        });
    }

    private function ensureAddressLimit(int $userId): void
    {
        if (
            Address::query()
                ->forUser($userId)
                ->count() >= AddressConstant::MAX_PER_USER
        ) {
            throw new AddressLimitExceededException(
                AddressConstant::MAX_PER_USER
            );
        }
    }
}
