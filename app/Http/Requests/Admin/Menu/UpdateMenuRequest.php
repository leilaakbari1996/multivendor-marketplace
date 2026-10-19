<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Menu;

use App\Models\Menu;
use Illuminate\Validation\Rule;

class UpdateMenuRequest extends BaseMenuRequest
{
    protected function urlRules(): array
    {
        return [
            'nullable',
            'string',
            'max:2048',
        ];
    }

    protected function parentIdRules(): array
    {
        $menu = $this->route('menu');

        if (! $menu instanceof Menu) {
            return [];
        }

        return [
            Rule::notIn([$menu->getKey()]),
        ];
    }
}
