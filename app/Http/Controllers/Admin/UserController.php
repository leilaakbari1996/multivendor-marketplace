<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\User\DeleteUserAction;
use App\Actions\Admin\User\StoreUserAction;
use App\Actions\Admin\User\UpdateUserAction;
use App\Constants\AdminView;
use App\Enums\MediaCollection;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\LocalFileUploader;
use App\Support\BadgeHelper;
use App\Traits\HasDatatable;

class UserController extends Controller
{
    use HasDatatable;

    public function __construct(
        private readonly StoreUserAction $storeUserAction,
        private readonly DeleteUserAction $deleteUserAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly LocalFileUploader $fileUploader,
    ) {
    }

    public function index()
    {
        $title = 'کاربران';

        return view(
            AdminView::USER_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: User::query()
                ->select([
                    'id',
                    'user_name',
                    'mobile',
                    'type',
                    'status',
                    'mobile_verified_at',
                ]),
            actionsView: 'admin.pages.users.partials._actions',
            extraColumns: [
                'type' => fn ($row) => $row->type->label(),

                'status' => fn ($row) => BadgeHelper::button($row->status),

                'mobile_verified_at' => fn ($row) => BadgeHelper::booleanButton(
                    value: (bool) $row->mobile_verified_at,
                    trueLabel: 'تأیید شده',
                    falseLabel: 'تأیید نشده',
                ),
            ],
        );
    }

    public function create()
    {
        $title = 'ایجاد کاربر';

        $types = UserType::options();

        $statuses = UserStatus::options();

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        return view(
            AdminView::USER_CREATE,
            compact(
                'title',
                'types',
                'statuses',
                'roles',
            )
        );
    }

    public function store(StoreRequest $request)
    {
        $this->storeUserAction->execute(
            $request->validated()
        );

        return redirect()
            ->route('panel.user.index')
            ->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        $user->load('media', 'roles');

        $types = UserType::options();

        $statuses = UserStatus::options();

        $roles = Role::query()
            ->orderBy('name')
            ->get();

        $image = $user->media
            ->where('collection', MediaCollection::AVATAR)
            ->first();

        $imageUrl = $image
            ? $this->fileUploader->url(
                path: $image->file_path,
                disk: $image->disk,
            )
            : null;

        $title = 'ویرایش کاربر';

        return view(
            AdminView::USER_EDIT,
            compact(
                'title',
                'user',
                'types',
                'statuses',
                'roles',
                'imageUrl',
            )
        );
    }

    public function update(UpdateRequest $request, User $user)
    {
        $this->updateUserAction->execute(
            $user,
            $request->validated()
        );

        return redirect()
            ->route('panel.user.index')
            ->with('success', 'کاربر با موفقیت ویرایش شد.');
    }

    public function destroy(User $user)
    {
        $this->deleteUserAction->execute($user);

        return response()->json([
            'message' => 'کاربر با موفقیت حذف شد.',
        ]);
    }
}
