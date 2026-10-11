<?php

namespace App\Actions\Client\Auth;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(array $credentials): bool
    {
        return Auth::attempt(
            [
                'mobile' => $credentials['phone'],
                'password' => $credentials['password'],
            ],
            $credentials['remember'] ?? false
        );
    }
}
