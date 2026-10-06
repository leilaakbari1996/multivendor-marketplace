<?php

namespace App\Http\Requests\Admin\Coupon;

use App\Enums\CouponType;
use App\Support\DateHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $coupon = $this->route('coupon');

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons', 'code')->ignore($coupon),
            ],

            'type' => [
                'required',
                Rule::enum(CouponType::class),
            ],

            'value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'min_order_amount' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'max_discount_amount' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'usage_limit' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => strtoupper(trim($this->code)),
            'is_active' => $this->boolean('is_active'),

            'starts_at' => DateHelper::toGregorian($this->starts_at),
            'expires_at' => DateHelper::toGregorian($this->expires_at),
        ]);
    }

}
