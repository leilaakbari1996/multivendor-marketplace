<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // اعداد فارسی/عربی را قبل از اعتبارسنجی انگلیسی می‌کنیم
    protected function prepareForValidation(): void
    {
        $map = [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ];

        $this->merge([
            'phone' => preg_replace('/\s+/', '', strtr((string) $this->phone, $map)),
            'user_name'  => trim((string) $this->user_name),
        ]);
    }

    public function rules(): array
    {
        return [
            'user_name'  => ['required', 'string', 'min:2', 'max:50'],
            'phone' => ['required', 'regex:/^09\d{9}$/', 'unique:users,mobile'],
            'password'  => ['required', 'string', 'min:8', 'max:100','confirmed'],
            'terms' => ['accepted'],
        ];
    }


//    public function messages(): array
//    {
//        return [
//            'required'     => ':attribute را وارد کنید.',
//            'min'          => ':attribute باید حداقل :min کاراکتر باشد.',
//            'max'          => ':attribute نباید بیشتر از :max کاراکتر باشد.',
//            'phone.regex'  => 'شماره موبایل معتبر نیست (مثال: 09120000000).',
//            'phone.unique' => 'این شماره قبلاً ثبت‌نام کرده است.',
//            'pass2.same'   => 'تکرار رمز عبور با رمز عبور یکسان نیست.',
//            'terms.accepted' => 'برای ثبت‌نام باید قوانین و مقررات را بپذیرید.',
//        ];
//    }
}
