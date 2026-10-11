<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'password'  => ['required', 'string', 'min:8', 'max:100','confirmed'],
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'phone.required' => 'شماره موبایل الزامی است.',
//            'phone.size' => 'شماره موبایل باید ۱۱ رقم باشد.',
//            'phone.regex' => 'شماره موبایل معتبر نیست.',
//
//            'code.required' => 'کد تأیید الزامی است.',
//            'code.digits' => 'کد تأیید باید ۶ رقم باشد.',
//
//            'password.required' => 'رمز عبور الزامی است.',
//            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
//            'password.confirmed' => 'تکرار رمز عبور با رمز عبور یکسان نیست.',
//        ];
//    }
}
