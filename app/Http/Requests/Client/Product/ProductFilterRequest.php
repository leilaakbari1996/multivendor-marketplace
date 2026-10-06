<?php

namespace App\Http\Requests\Client\Product;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                'integer',
                Rule::exists(Category::class, 'id'),
            ],

            'min_price' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],

            'max_price' => [
                    'nullable',
                    'integer',
                    'min:0',
                    Rule::when(
                        $this->filled('min_price'),
                        ['gte:min_price']
                    ),
                ],

            'in_stock' => [
                'nullable',
                'boolean',
            ],

            'on_sale' => [
                'nullable',
                'boolean',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'is_best_selling' => [
                'nullable',
                'boolean',
            ],

            'sort' => [
                'nullable',
                Rule::in([
                    'latest',
                    'price_asc',
                    'price_desc',
                ]),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'in_stock' => $this->boolean('in_stock'),
            'on_sale' => $this->boolean('on_sale'),
        ]);
    }
}

