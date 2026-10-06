<?php

namespace App\Actions\Admin\Menu;

use App\Models\Menu;

class UpdateMenuAction
{
    public function execute(Menu $menu, array $data): Menu
    {
        $menu->update($data);

        return $menu->refresh();
    }
}
