<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use App\Enums\UserType;
use App\Enums\UserStatus;

class StoreUserRequest extends BaseUserRequest
{
    protected function mobileUniqueRule(): Unique
    {
        return Rule::unique('users', 'mobile');
    }

    protected function typeRules(): array
    {
        return [
            'nullable',
            Rule::enum(UserType::class),
        ];
    }

    protected function statusRules(): array
    {
        return [
            'nullable',
            Rule::enum(UserStatus::class),
        ];
    }

    protected function imageRules(): array
    {
        return [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:3072',
        ];
    }
}
