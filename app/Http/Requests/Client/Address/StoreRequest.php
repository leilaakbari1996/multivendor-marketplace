<?php

namespace App\Http\Requests\Client\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * ارقام فارسی/عربی را قبل از اعتبارسنجی به انگلیسی تبدیل می‌کند.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'recipient_mobile' => $this->digits($this->input('recipient_mobile')),
            'postal_code'      => $this->digits($this->input('postal_code')),
            'plaque'           => $this->digits($this->input('plaque')),
        ]);
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'min:2', 'max:30'],
            'recipient_name'   => ['required', 'string', 'min:3', 'max:60'],
            'recipient_mobile' => ['required', 'regex:/^09\d{9}$/'],

            // سلسله‌مراتب: شهر باید زیرمجموعه‌ی بخش، بخش زیرمجموعه‌ی شهرستان و ...
            'province_id' => ['required', 'integer', Rule::exists('iran_provinces', 'id')],
            'county_id'   => ['required', 'integer',
                Rule::exists('iran_counties', 'id')->where('province_id', $this->input('province_id'))],
            'sector_id'   => ['required', 'integer',
                Rule::exists('iran_sectors', 'id')->where('county_id', $this->input('county_id'))],
            'city_id'     => ['required', 'integer',
                Rule::exists('iran_cities', 'id')->where('sector_id', $this->input('sector_id'))],

            'address'     => ['required', 'string', 'min:10', 'max:1000'],
            'postal_code' => ['required', 'digits:10'],
            'plaque'      => ['nullable', 'integer', 'between:1,65535'],
            'unit'        => ['nullable', 'string', 'max:10'],
            'is_default'  => ['sometimes', 'boolean'],
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'title.required' => 'عنوان آدرس را وارد کنید.',
//            'title.min'      => 'عنوان آدرس باید حداقل ۲ حرف باشد.',
//            'title.max'      => 'عنوان آدرس حداکثر ۳۰ حرف باشد.',
//
//            'recipient_name.required' => 'نام گیرنده را وارد کنید.',
//            'recipient_name.min'      => 'نام گیرنده باید حداقل ۳ حرف باشد.',
//            'recipient_name.max'      => 'نام گیرنده حداکثر ۶۰ حرف باشد.',
//
//            'recipient_mobile.required' => 'شماره موبایل را وارد کنید.',
//            'recipient_mobile.regex'    => 'شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود.',
//
//            'province_id.required' => 'استان را انتخاب کنید.',
//            'province_id.exists'   => 'استان انتخاب‌شده معتبر نیست.',
//            'county_id.required'   => 'شهرستان را انتخاب کنید.',
//            'county_id.exists'     => 'شهرستان انتخاب‌شده متعلق به این استان نیست.',
//            'sector_id.required'   => 'بخش را انتخاب کنید.',
//            'sector_id.exists'     => 'بخش انتخاب‌شده متعلق به این شهرستان نیست.',
//            'city_id.required'     => 'شهر را انتخاب کنید.',
//            'city_id.exists'       => 'شهر انتخاب‌شده متعلق به این بخش نیست.',
//
//            'address.required' => 'آدرس را وارد کنید.',
//            'address.min'      => 'آدرس را کامل‌تر وارد کنید (حداقل ۱۰ حرف).',
//            'address.max'      => 'آدرس بیش از حد طولانی است.',
//
//            'postal_code.required' => 'کد پستی را وارد کنید.',
//            'postal_code.digits'   => 'کد پستی باید ۱۰ رقم باشد.',
//
//            'plaque.integer' => 'پلاک باید عددی بین ۱ تا ۶۵۵۳۵ باشد.',
//            'plaque.between' => 'پلاک باید عددی بین ۱ تا ۶۵۵۳۵ باشد.',
//
//            'unit.max' => 'واحد حداکثر ۱۰ حرف باشد.',
//        ];
//    }

    private function digits(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return strtr($value, [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
        ]);
    }
}
