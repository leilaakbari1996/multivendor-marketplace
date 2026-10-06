<?php

namespace App\Http\Requests\Admin\Banner;

use App\Enums\BannerPosition;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'url' => ['nullable', 'string', 'max:2048'],
            'position' => [
                'required',
                Rule::enum(BannerPosition::class),
            ],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [
                'nullable',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'gif']),
            ],
        ];
    }

}
