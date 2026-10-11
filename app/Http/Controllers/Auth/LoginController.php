<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Client\Auth\LoginAction;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;

class LoginController
{
    public function index()
    {
        return view('client.pages.auth.login');
    }

    public function store(LoginRequest $request, LoginAction $action)
    {
        if (! $action->execute($request->validated())) {
            throw ValidationException::withMessages([
                'phone' => 'شماره موبایل یا رمز عبور اشتباه است.',
            ]);
        }

        $request->session()->regenerate();

        return ApiResponse::success(
            message: 'ورود با موفقیت انجام شد.',
            data: [
                'redirect' => route('home'),
            ],
        );
    }

}
