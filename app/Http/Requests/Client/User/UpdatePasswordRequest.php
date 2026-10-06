<?php
// app/Http/Requests/Client/UpdatePasswordRequest.php

namespace App\Http\Requests\Client\User;

use App\Support\AuthUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'password' => ['required', 'confirmed', Password::min(8)],
        ];

        // اگه کاربر قبلاً رمز داشته، رمز فعلی الزامیه
        if (filled(AuthUser::user()->password)) {
            $rules['current_password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    if (! Hash::check($value, AuthUser::user()->password)) {
                        $fail('رمز عبور فعلی اشتباه است.');
                    }
                },
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'current_password' => 'رمز فعلی',
            'password'         => 'رمز جدید',
        ];
    }

}
