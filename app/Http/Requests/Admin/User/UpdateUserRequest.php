<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateUserRequest extends BaseUserRequest
{
    protected function mobileUniqueRule(): Unique
    {
        $user = $this->route('user');

        return Rule::unique('users', 'mobile')
            ->ignore($user instanceof User ? $user : null);
    }

    protected function typeRules(): array
    {
        return [
            'required',
            Rule::enum(UserType::class),
        ];
    }

    protected function statusRules(): array
    {
        return [
            'required',
            Rule::enum(UserStatus::class),
        ];
    }

    protected function imageRules(): array
    {
        if ($this->hasFile('image')) {
            return [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ];
        }

        return [
            'nullable',
            'string',
        ];
    }
}
