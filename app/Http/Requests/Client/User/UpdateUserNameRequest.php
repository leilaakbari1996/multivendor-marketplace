<?php
// app/Http/Requests/Client/UpdateProfileRequest.php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string', 'min:3', 'max:100'],
        ];
    }
}
