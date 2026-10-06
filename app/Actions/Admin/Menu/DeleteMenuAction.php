<?php

namespace App\Actions\Admin\Menu;

use App\Models\Menu;

class DeleteMenuAction
{
    public function execute(Menu $menu): bool
    {
        return (bool) $menu->delete();
    }
}
