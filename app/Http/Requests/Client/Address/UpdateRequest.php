<?php

namespace App\Http\Requests\Client\Address;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'recipient_mobile' => $this->digits(
                $this->input('recipient_mobile')
            ),
            'postal_code' => $this->digits(
                $this->input('postal_code')
            ),
            'plaque' => $this->digits(
                $this->input('plaque')
            ),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:2',
                'max:30',
            ],

            'recipient_name' => [
                'required',
                'string',
                'min:3',
                'max:60',
            ],

            'recipient_mobile' => [
                'required',
                'regex:/^09\d{9}$/',
            ],

            // استان
            'province_id' => [
                'required',
                'integer',
                Rule::exists('iran_provinces', 'id'),
            ],

            // شهرستان ← متعلق به استان
            'county_id' => [
                'required',
                'integer',
                Rule::exists('iran_counties', 'id')
                    ->where(
                        'province_id',
                        $this->input('province_id')
                    ),
            ],

            // بخش ← متعلق به شهرستان
            'sector_id' => [
                'required',
                'integer',
                Rule::exists('iran_sectors', 'id')
                    ->where(
                        'county_id',
                        $this->input('county_id')
                    ),
            ],

            // شهر ← متعلق به بخش
            'city_id' => [
                'required',
                'integer',
                Rule::exists('iran_cities', 'id')
                    ->where(
                        'sector_id',
                        $this->input('sector_id')
                    ),
            ],

            'address' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],

            'postal_code' => [
                'required',
                'digits:10',
            ],

            'plaque' => [
                'nullable',
                'integer',
                'between:1,65535',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:10',
            ],

            'is_default' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    private function digits(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return strtr($value, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',

            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);
    }
}
