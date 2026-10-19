<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Permission\StorePermissionAction;
use App\Actions\Admin\Permission\UpdatePermissionAction;
use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\StoreRequest;
use App\Http\Requests\Admin\Permission\UpdateRequest;
use App\Models\Permission;
use App\Traits\HasDatatable;

class PermissionController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StorePermissionAction $storePermissionAction,
        private readonly UpdatePermissionAction $updatePermissionAction,
    ) {}

    public function index()
    {
        $title = 'دسترسی‌ها';

        return view(
            AdminView::PERMISSION_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Permission::query()
                ->select([
                    'id',
                    'name',
                    'slug',
                ]),
            actionsView: 'admin.pages.permissions.partials._actions',
        );
    }

    public function create()
    {
        $title = 'ایجاد دسترسی';

        return view(
            AdminView::PERMISSION_CREATE,
            compact('title')
        );
    }

    public function store(StoreRequest $request)
    {
        $this->storePermissionAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PREFIX_ROUTE . 'permission.index')
            ->with('success', 'دسترسی با موفقیت ایجاد شد.');
    }

    public function edit(Permission $permission)
    {
        $title = 'ویرایش دسترسی';

        return view(
            AdminView::PERMISSION_EDIT,
            compact(
                'title',
                'permission',
            )
        );
    }

    public function update(
        UpdateRequest $request,
        Permission $permission
    ) {
        $this->updatePermissionAction->execute(
            permission: $permission,
            data: $request->validated(),
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'permission.index')
            ->with('success', 'دسترسی با موفقیت ویرایش شد.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => 'دسترسی با موفقیت حذف شد.',
        ]);
    }
}
