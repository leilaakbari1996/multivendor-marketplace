<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Menu;

use App\Enums\MenuLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseMenuRequest extends FormRequest
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
            'url' => $this->urlRules(),
            'location' => [
                'required',
                Rule::enum(MenuLocation::class),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menus', 'id'),
                ...$this->parentIdRules(),
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

    abstract protected function urlRules(): array;

    abstract protected function parentIdRules(): array;
}
