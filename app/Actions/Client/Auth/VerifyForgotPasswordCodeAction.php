<?php

namespace App\Actions\Client\Auth;

use App\Constants\Client\Auth\OTPConstant;
use App\Models\Otp;
use App\Queries\OtpQuery;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyForgotPasswordCodeAction
{

    public function __construct(
        private readonly OtpQuery $otpQuery,
    ) {}

    public function execute(
        string $phone,
        string $code,
    ): bool {
        $otp = $this->otpQuery->findByMobile($phone);

        if (! $otp) {
            throw new HttpException(
                422,
                'کد تأیید یافت نشد. لطفاً کد جدید دریافت کنید.'
            );
        }

        if ($otp->expires_at->isPast()) {
            throw new HttpException(
                422,
                'کد تأیید منقضی شده است. لطفاً کد جدید دریافت کنید.'
            );
        }

        if ($otp->attempts >= OTPConstant::MAX_ATTEMPTS) {
            throw new HttpException(
                422,
                'تعداد تلاش‌های مجاز به پایان رسیده است.'
            );
        }

        if ($otp->code !== $code) {
            $otp->increment('attempts');

            throw new HttpException(
                422,
                'کد تأیید صحیح نیست.'
            );
        }

        session()->put('password_reset_phone', $phone);

        $otp->delete();

        return true;
    }
}

