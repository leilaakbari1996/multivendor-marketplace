<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Client\Auth\RegisterAction;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController
{
    public function index()
    {
        return view('client.pages.auth.register');
    }

    public function store(
        RegisterRequest $request,
        RegisterAction $action,
    ): JsonResponse {
        $user = $action->execute(
            $request->validated()
        );

        Auth::login($user);

        $request->session()->regenerate();

        return ApiResponse::success(
            message: 'ثبت‌نام با موفقیت انجام شد.',
            data: [
                'redirect' => route('home'),
            ],
            status: 201,
        );
    }

}
