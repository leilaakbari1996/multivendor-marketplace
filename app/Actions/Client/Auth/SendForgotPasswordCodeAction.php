<?php

namespace App\Actions\Client\Auth;

use App\Constants\Client\Auth\OTPConstant;
use App\Queries\OtpQuery;
use App\Queries\UserQuery;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SendForgotPasswordCodeAction
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly OtpQuery $otpQuery,
    ) {}

    public function execute(string $phone): void
    {
        $userExists = $this->userQuery->existsByMobile($phone);

        if (! $userExists) {
            throw new HttpException(
                422,
                'کاربری با این شماره موبایل پیدا نشد.'
            );
        }

        $existingOtp = $this->otpQuery->findByMobile($phone);

        if ($existingOtp && $existingOtp->expires_at->isFuture()) {
            $remainingSeconds = now()->diffInSeconds(
                $existingOtp->expires_at
            );

            throw new HttpException(
                422,
                'کد تأیید قبلی هنوز معتبر است. لطفاً ' .
                $this->formatRemainingTime($remainingSeconds) .
                ' صبر کنید.'
            );
        }

        $code = $this->generateOtpCode();

        DB::transaction(function () use ($phone, $code) {
            $this->otpQuery->delete($phone);

            $this->otpQuery->create([
                'mobile' => $phone,
                'code' => $code,
                'expires_at' => now()->addSeconds(OTPConstant::OTP_TTL),
            ]);

            // TODO:
            // ارسال کد با سرویس SMS
        });
    }

    private function generateOtpCode(): string
    {
        return (string) random_int(10000, 99999);
    }

    private function formatRemainingTime(int $seconds): string
    {
        $minutes = intdiv($seconds, 60);
        $seconds %= 60;

        return match (true) {
            $minutes > 0 && $seconds > 0 =>
            "{$minutes} دقیقه و {$seconds} ثانیه",

            $minutes > 0 =>
            "{$minutes} دقیقه",

            default =>
            "{$seconds} ثانیه",
        };
    }
}
