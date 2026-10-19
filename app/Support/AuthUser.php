<?php

namespace App\Support;

use App\Models\User;

final class AuthUser
{
    public static function user(): ?User
    {
        $user = auth()->user();

        return $user instanceof User ? $user : null;
    }

    public static function id(): ?int
    {
        return auth()->id();
    }

    public static function check(): bool
    {
        return auth()->check();
    }
}

