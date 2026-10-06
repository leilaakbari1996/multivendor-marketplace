<?php

namespace App\Http\Requests\Admin\Vendor;

use App\Enums\VendorStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
//                Rule::unique('vendors', 'user_id'),
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
                'unique:vendors,url',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072',
            ],

            'banner' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'national_code' => [
                'nullable',
                'string',
                'size:10',
                'unique:vendors,national_code',
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
    }
}
