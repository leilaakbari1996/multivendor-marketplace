<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Menu;

class StoreMenuRequest extends BaseMenuRequest
{
    protected function urlRules(): array
    {
        return [
            'required',
            'string',
            'max:2048',
        ];
    }

    protected function parentIdRules(): array
    {
        return [];
    }
}
