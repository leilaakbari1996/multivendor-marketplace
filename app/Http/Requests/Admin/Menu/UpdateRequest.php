<?php

namespace App\Http\Requests\Admin\Menu;

use App\Enums\MenuLocation;
use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Menu $menu */
        $menu = $this->route('menu');

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'url' => [
                'nullable',
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
                Rule::notIn([$menu->id]),
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
