<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyForgotPasswordCodeRequest extends FormRequest
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

            'code' => [
                'required',
                'digits:5',
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
//
//            'code.required' => 'کد تأیید الزامی است.',
//            'code.digits' => 'کد تأیید باید ۶ رقم باشد.',
//        ];
//    }
}

