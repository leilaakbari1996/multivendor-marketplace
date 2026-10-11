<?php

namespace App\Actions\Client\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    /**
     * @return array{user: User, token: string}
     */
    public function execute(array $data): User
    {
        $user = User::query()->create([
            'user_name'     => $data['user_name'],
            'mobile'        => $data['phone'],
            'password'      => Hash::make($data['password']),
        ]);

        return $user;
    }
}
