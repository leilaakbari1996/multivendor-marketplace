<?php

namespace App\View\Composers;

use App\Enums\MenuLocation;
use App\Models\Menu;
use Illuminate\View\View;

class NavigationComposer
{
    public function compose(View $view): void
    {
        $menus = Menu::byLocations([
            MenuLocation::HEADER,
            MenuLocation::FOOTER,
        ])->get()->groupBy('location');

        $view->with([
            'headerMenus' => $menus['header'],
            'footerMenus' => $menus['footer'],
        ]);
    }


}

