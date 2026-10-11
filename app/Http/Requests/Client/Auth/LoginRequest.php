<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'regex:/^09\d{9}$/',
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'phone.required' => 'شماره موبایل را وارد کنید.',
//            'phone.regex' => 'شماره موبایل معتبر نیست.',
//            'password.required' => 'رمز عبور را وارد کنید.',
//        ];
//    }
}
