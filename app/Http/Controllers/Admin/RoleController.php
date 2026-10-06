<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Role\StoreRoleAction;
use App\Actions\Admin\Role\UpdateRoleAction;
use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRequest;
use App\Http\Requests\Admin\Role\UpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\HasDatatable;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreRoleAction $storeRoleAction,
        private readonly UpdateRoleAction $updateRoleAction,
    ) {}

    public function index()
    {
        $title = 'نقش‌ها';

        return view(
            AdminView::ROLE_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Role::query()
                ->select([
                    'id',
                    'name',
                    'name_en',
                ])
                ->withCount('permissions')
            ,
            actionsView: 'admin.pages.roles.partials._actions',
        );
    }

    public function create()
    {
        $title = 'ایجاد نقش';

        $permissions = Permission::query()
            ->orderBy('slug')
            ->get()
            ->groupBy(
                fn (Permission $permission) =>
                Str::before($permission->slug, '.')
            );

        return view(
            AdminView::ROLE_CREATE,
            compact(
                'title',
                'permissions'
            )
        );
    }

    public function store(StoreRequest $request)
    {
        $this->storeRoleAction->execute(
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'role.index')
            ->with('success', 'نقش با موفقیت ایجاد شد.');
    }

    public function edit(Role $role)
    {
        $title = 'ویرایش نقش';

        $role->load('permissions');

        $permissions = Permission::query()
            ->orderBy('slug')
            ->get()
            ->groupBy(
                fn (Permission $permission) =>
                Str::before($permission->slug, '.')
            );

        return view(
            AdminView::ROLE_EDIT,
            compact(
                'title',
                'role',
                'permissions'
            )
        );
    }

    public function update(
        UpdateRequest $request,
        Role $role
    ) {
        $this->updateRoleAction->execute(
            role: $role,
            data: $request->validated(),
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'role.index')
            ->with('success', 'نقش با موفقیت ویرایش شد.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'نقش با موفقیت حذف شد.',
        ]);
    }
}
