<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Client\Auth\ResetPasswordAction;
use App\Actions\Client\Auth\SendForgotPasswordCodeAction;
use App\Actions\Client\Auth\VerifyForgotPasswordCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ResetPasswordRequest;
use App\Http\Requests\Client\Auth\SendForgotPasswordCodeRequest;
use App\Http\Requests\Client\Auth\VerifyForgotPasswordCodeRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ForgetController extends Controller
{
    public function __construct(
        private readonly SendForgotPasswordCodeAction $sendForgotPasswordCodeAction,
        private readonly VerifyForgotPasswordCodeAction $verifyForgotPasswordCodeAction,
        private readonly ResetPasswordAction $resetPasswordAction,
    ) {}

    public function index(): View
    {
        return view('client.pages.auth.forgot');
    }

    public function sendCode(
        SendForgotPasswordCodeRequest $request
    ): JsonResponse {
        $this->sendForgotPasswordCodeAction->execute(
            phone: $request->string('phone')->toString(),
        );

        return ApiResponse::success(
            message: 'کد تأیید با موفقیت ارسال شد.'
        );
    }

    public function verifyCode(
        VerifyForgotPasswordCodeRequest $request
    ): JsonResponse {
        $this->verifyForgotPasswordCodeAction->execute(
            phone: $request->string('phone')->toString(),
            code: $request->string('code')->toString(),
        );

        return ApiResponse::success(
            message: 'کد تأیید با موفقیت تأیید شد.'
        );
    }

    public function reset(
        ResetPasswordRequest $request
    ): JsonResponse {
        $this->resetPasswordAction->execute(
            password: $request->string('password')->toString(),
        );

        return ApiResponse::success(
            'رمز عبور با موفقیت تغییر کرد.',
            data: [
                'redirect' => route('login'),
            ],
        );
    }
}

