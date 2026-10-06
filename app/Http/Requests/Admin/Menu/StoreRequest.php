<?php

namespace App\Http\Requests\Admin\Menu;

use App\Enums\MenuLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'required',
                'string',
                'max:2048',
            ],

            'location' => [
                'required',
                Rule::enum(MenuLocation::class),
            ],

            'parent_id' => [
                'nullable',
                'integer',
                'exists:menus,id',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

}

