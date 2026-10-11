<?php

namespace App\Actions\Client\Auth;

use App\Models\User;
use App\Queries\UserQuery;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResetPasswordAction
{
    public function __construct(
        private readonly UserQuery $userQuery,
    ) {}

    public function execute(string $password): void
    {
        $phone = session('password_reset_phone');

        if (! $phone) {
            throw new HttpException(
                422,
                'فرآیند تغییر رمز معتبر نیست. لطفاً دوباره درخواست دهید.'
            );
        }

        $user = $this->userQuery->findByMobile($phone);

        if (! $user) {
            throw new HttpException(
                422,
                'فرآیند تغییر رمز معتبر نیست. لطفاً دوباره درخواست دهید.'
            );
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        session()->forget('password_reset_phone');
    }
}

