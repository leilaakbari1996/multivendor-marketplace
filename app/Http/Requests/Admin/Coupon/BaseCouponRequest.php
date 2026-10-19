<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Coupon;

use App\Enums\CouponType;
use App\Support\DateHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => filled($this->input('code'))
                ? strtoupper(trim($this->input('code')))
                : $this->input('code'),

            'is_active' => $this->boolean('is_active'),

            'starts_at' => filled($this->input('starts_at'))
                ? DateHelper::toGregorian($this->input('starts_at'))
                : null,

            'expires_at' => filled($this->input('expires_at'))
                ? DateHelper::toGregorian($this->input('expires_at'))
                : null,
        ]);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                $this->codeUniqueRule(),
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
                'required',
                'boolean',
            ],
        ];
    }

    abstract protected function codeUniqueRule(): mixed;
}
