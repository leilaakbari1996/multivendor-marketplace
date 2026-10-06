<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Menu\DeleteMenuAction;
use App\Actions\Admin\Menu\StoreMenuAction;
use App\Actions\Admin\Menu\UpdateMenuAction;
use App\Constants\AdminView;
use App\Enums\MenuLocation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Menu\StoreRequest;
use App\Http\Requests\Admin\Menu\UpdateRequest;
use App\Models\Menu;
use App\Traits\HasDatatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreMenuAction $storeMenuAction,
        private readonly UpdateMenuAction $updateMenuAction,
        private readonly DeleteMenuAction $deleteMenuAction,
    ) {
    }

    public function index(): View
    {
        $title = 'منوها';

        return view(
            AdminView::MENU_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Menu::query()
                ->select([
                    'id',
                    'title',
                    'slug',
                    'url',
                    'location',
                    'parent_id',
                    'sort_order',
                    'is_active',
                ]),
            actionsView: 'admin.pages.menus.partials._actions',
            extraColumns: [
                'location' => fn ($row) => $row->location->label(),

                'is_active' => fn ($row) => \App\Support\BadgeHelper::booleanButton(
                    value: (bool) $row->is_active,
                    trueLabel: 'فعال',
                    falseLabel: 'غیرفعال',
                ),
            ],
        );
    }

    public function create(): View
    {
        $title = 'ایجاد منو';

        $locations = collect(MenuLocation::cases())
            ->mapWithKeys(
                fn (MenuLocation $location) => [
                    $location->value => $location->label(),
                ]
            )
            ->toArray();

        $menus = Menu::rootMenuOptions();

        return view(
            AdminView::MENU_CREATE,
            compact(
                'title',
                'locations',
                'menus'
            )
        );
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->storeMenuAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'menu.index')
            ->with('success', 'منو با موفقیت ایجاد شد.');
    }

    public function edit(Menu $menu): View
    {
        $title = 'ویرایش منو';
        $locations = collect(MenuLocation::cases())
            ->mapWithKeys(
                fn (MenuLocation $location) => [
                    $location->value => $location->label(),
                ]
            )
            ->toArray();

        $menus = Menu::rootMenuOptions();

        return view(
            AdminView::MENU_EDIT,
            compact(
                'title',
                'locations',
                'menus',
                'menu'
            )
        );

    }

    public function update(
        UpdateRequest $request,
        Menu $menu
    ): RedirectResponse {
        $this->updateMenuAction->execute(
            $menu,
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'menu.index')
            ->with('success', 'منو با موفقیت ویرایش شد.');
    }

    public function destroy(Menu $menu)
    {
        $this->deleteMenuAction->execute($menu);

        return response()->json([
            'message' => 'منو با موفقیت حذف شد.',
        ]);
    }
}
