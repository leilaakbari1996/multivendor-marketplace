<?php

namespace App\Support;

use App\Models\User;

class AuthUser
{
    private static ?User $user = null;
    public static function user(): ?User
    {
        if (is_null(self::$user))
        {
            self::$user = auth()->user();;
        }
        return self::$user;
        return auth()->user();
        self::$user =  User::query()->findOrFail(self::id());
    }

    public static function id(): ?int
    {
        return auth()->id();
    }

    public static function check()
    {
        return auth()->check();
    }
}

