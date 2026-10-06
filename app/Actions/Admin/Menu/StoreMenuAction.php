<?php

namespace App\Actions\Admin\Menu;

use App\Models\Menu;

class StoreMenuAction
{
    public function execute(array $data): Menu
    {
        return Menu::create($data);
    }
}
