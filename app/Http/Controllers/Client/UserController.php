<?php

namespace App\Http\Controllers\Client;

use App\Actions\Client\User\UpdateUserAction;
use App\Constants\ClientView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\UpdateAvatarRequest;
use App\Http\Requests\Client\User\UpdatePasswordRequest;
use App\Http\Requests\Client\User\UpdateUserNameRequest;
use App\Http\Responses\ApiResponse;
use App\Queries\LikeQuery;
use App\Queries\UserQuery;
use App\Support\AuthUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly LikeQuery $likeQuery,
        private readonly UpdateUserAction $updateUserAction,
    ) {}

    public function index(): View
    {
        return view(
            ClientView::PREFIX.'users.index',
            $this->userQuery->profile()
        );
    }

    public function likes(): View
    {
        $userId = AuthUser::id();

        return view(
            ClientView::PREFIX . 'users.favorites',
            [
                'products' => $this->likeQuery->products($userId),
                'posts' => $this->likeQuery->posts($userId),
            ]
        );
    }


    public function update(UpdateUserNameRequest $request): JsonResponse
    {
        $this->updateUserAction->execute(AuthUser::user(), $request->validated());

        return ApiResponse::success('اطلاعات حساب با موفقیت به‌روزرسانی شد.');
    }

    public function updateAvatar(UpdateAvatarRequest $request): JsonResponse
    {
        $user = $this->updateUserAction->execute(AuthUser::user(), [
            'avatar' => $request->file('avatar'),
        ]);

        return ApiResponse::success('عکس پروفایل به‌روزرسانی شد.', [
            'url' => $user->avatar?->url,
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = AuthUser::user();
        $hadPassword = filled($user->password);

        $this->updateUserAction->execute($user, $request->validated());

        return ApiResponse::success($hadPassword ? 'رمز عبور با موفقیت تغییر کرد.' : 'رمز عبور با موفقیت تعیین شد.');
    }

}
