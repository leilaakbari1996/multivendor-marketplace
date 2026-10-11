<?php

namespace App\Queries;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Support\AuthUser;

class UserQuery
{

    public function profile(): array
    {
        return [
            'user' => AuthUser::user(),
        ];
    }

    public function findByMobile(string $phone): ?User
    {
        return User::query()
            ->forMobile($phone)
            ->first();
    }

    public function existsByMobile(string $phone): bool
    {
        return User::query()
            ->forMobile($phone)
            ->exists();
    }

    public function customersCount(): int
    {
        return User::query()
            ->where('type', UserType::CUSTOMER)
            ->where('status', UserStatus::ACTIVE)
            ->count();
    }

}
