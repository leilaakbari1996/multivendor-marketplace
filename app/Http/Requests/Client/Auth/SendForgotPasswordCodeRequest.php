<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendForgotPasswordCodeRequest extends FormRequest
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
                'size:11',
                'regex:/^09\d{9}$/',
            ],
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'phone.required' => 'شماره موبایل الزامی است.',
//            'phone.string' => 'شماره موبایل باید به صورت صحیح وارد شود.',
//            'phone.size' => 'شماره موبایل باید ۱۱ رقم باشد.',
//            'phone.regex' => 'شماره موبایل معتبر نیست.',
//        ];
//    }
}
