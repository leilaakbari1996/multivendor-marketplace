<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StoreProductRequest extends BaseProductRequest
{
    protected function skuUniqueRule(): Unique
    {
        return Rule::unique('products', 'sku');
    }

    protected function imageRules(): array
    {
        return [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:3072',
        ];
    }
}
