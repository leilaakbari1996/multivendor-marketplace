<?php

namespace App\Http\Requests\Admin\Vendor;

use App\Enums\VendorStatus;
use App\Models\Vendor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Vendor $vendor */
        $vendor = $this->route('vendor');

        $rules =  [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'store_name' => [
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vendors', 'url')
                    ->ignore($vendor->id),
            ],
            'logo' => ['nullable'],
            'banner' => ['nullable'],
            'bio' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'national_code' => [
                'nullable',
                'string',
                'size:10',
            ],

            'commission_rate' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'status' => [
                'required',
                Rule::enum(VendorStatus::class),
            ],
        ];
        if ($this->hasFile('logo')) {
            $rules['logo'][] = 'image';
            $rules['logo'][] = 'mimes:jpg,jpeg,png,webp';
            $rules['logo'][] = 'max:3072';
        } else {
            // اگر فایل نیست، پس باید رشته (URL فایل موجود) یا خالی باشه
            $rules['logo'][] = 'string';
        }

        if ($this->hasFile('banner')) {
            $rules['banner'][] = 'image';
            $rules['banner'][] = 'mimes:jpg,jpeg,png,webp';
            $rules['banner'][] = 'max:3072';
        } else {
            // اگر فایل نیست، پس باید رشته (URL فایل موجود) یا خالی باشه
            $rules['banner'][] = 'string';
        }
        return $rules;

    }
}
