<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Vendor;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StoreVendorRequest extends BaseVendorRequest
{
    protected function urlUniqueRule(): Unique
    {
        return Rule::unique('vendors', 'url');
    }

    protected function nationalCodeUniqueRule(): Unique
    {
        return Rule::unique('vendors', 'national_code');
    }

    protected function logoRules(): array
    {
        return [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:3072',
        ];
    }

    protected function bannerRules(): array
    {
        return [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ];
    }
}
