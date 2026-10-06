<?php

namespace App\Http\Requests\Admin\Product;

use App\Enums\ProductStatus;
use App\Support\DateHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => [
                'required',
                'integer',
                'exists:vendors,id',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku',
            ],

            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],

            'price' => [
                'required',
                'integer',
                'min:0',
            ],

            'discount_price' => [
                'nullable',
                'integer',
                'min:0',
                'lte:price',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'weight' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::enum(ProductStatus::class),
            ],

            'is_featured' => [
                'boolean',
            ],

            'featured_from' => [
                'nullable',
                'date',
            ],

            'featured_until' => [
                'nullable',
                'date',
                'after_or_equal:featured_from',
            ],

            'is_best_selling' => [
                'boolean',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_best_selling' => $this->boolean('is_best_selling'),
            'featured_from' => DateHelper::toGregorian($this->featured_from, 'Y/m/d H:i:s'),
            'featured_until' => DateHelper::toGregorian($this->featured_until, 'Y/m/d H:i:s'),
        ]);
    }
}

