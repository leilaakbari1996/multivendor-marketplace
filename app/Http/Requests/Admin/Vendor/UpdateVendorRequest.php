<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Vendor;

use App\Models\Vendor;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateVendorRequest extends BaseVendorRequest
{
    protected function urlUniqueRule(): Unique
    {
        $vendor = $this->route('vendor');

        return Rule::unique('vendors', 'url')
            ->ignore($vendor instanceof Vendor ? $vendor : null);
    }

    protected function nationalCodeUniqueRule(): Unique
    {
        $vendor = $this->route('vendor');

        return Rule::unique('vendors', 'national_code')
            ->ignore($vendor instanceof Vendor ? $vendor : null);
    }

    protected function logoRules(): array
    {
        if ($this->hasFile('logo')) {
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

    protected function bannerRules(): array
    {
        if ($this->hasFile('banner')) {
            return [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ];
        }

        return [
            'nullable',
            'string',
        ];
    }
}
