<?php

namespace App\Queries;

use App\Models\User;
use App\Support\AuthUser;

class UserQuery
{
    public function user(): User
    {
        return AuthUser::user();
    }

    public function profile(): array
    {
        return [
            'user' => $this->user(),
        ];
    }

}
