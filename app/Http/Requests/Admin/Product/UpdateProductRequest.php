<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateProductRequest extends BaseProductRequest
{
    protected function skuUniqueRule(): Unique
    {
        $product = $this->route('product');

        return Rule::unique('products', 'sku')
            ->ignore($product instanceof Product ? $product : null);
    }

    protected function imageRules(): array
    {
        if ($this->hasFile('image')) {
            return [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ];
        }

        return [
            'nullable',
            'string',
        ];
    }

    protected function additionalRules(): array
    {
        $product = $this->route('product');

        return [
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'slug')
                    ->ignore($product instanceof Product ? $product : null),
            ],
        ];
    }
}
