<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use App\Enums\ProductStatus;
use App\Support\DateHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

abstract class BaseProductRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $featuredFrom = $this->input('featured_from');
        $featuredUntil = $this->input('featured_until');

        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_best_selling' => $this->boolean('is_best_selling'),
            'featured_from' => filled($featuredFrom)
                ? DateHelper::toGregorian($featuredFrom, 'Y/m/d H:i:s')
                : null,
            'featured_until' => filled($featuredUntil)
                ? DateHelper::toGregorian($featuredUntil, 'Y/m/d H:i:s')
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
                'vendor_id' => [
                    'required',
                    'integer',
                    Rule::exists('vendors', 'id'),
                ],
                'category_id' => [
                    'required',
                    'integer',
                    Rule::exists('categories', 'id'),
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
                    $this->skuUniqueRule(),
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
                'image' => $this->imageRules(),
            ] + $this->additionalRules();
    }

    abstract protected function skuUniqueRule(): Unique;

    abstract protected function imageRules(): array;

    protected function additionalRules(): array
    {
        return [];
    }
}
