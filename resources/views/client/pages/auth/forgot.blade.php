@extends('client.pages.auth.layout')

@section('auth-content')
    <section class="view" id="forgot">
        <h1>فراموشی رمز عبور</h1>

        <p class="sub" id="f-sub">
            شماره موبایل خود را وارد کنید تا کد تأیید برایتان ارسال شود.
        </p>

        <div class="notice" id="f-notice"></div>

        {{-- مرحله اول: شماره موبایل --}}
        <form
            novalidate
            id="f1"
        >
            <x-client.forms.input
                id="f-phone"
                name="phone"
                type="tel"
                label="شماره موبایل"
                dir="ltr"
                inputmode="numeric"
                placeholder="09120000000"
                autocomplete="tel"
            />

            <x-client.button
                type="submit"
                class="w-100"
                id="send-code"
            >
                ارسال کد تأیید
            </x-client.button>
        </form>

        {{-- مرحله دوم: کد تأیید --}}
        <form
            novalidate
            id="f2"
            style="display: none"
        >
            <div class="otp" id="otp">
                @for ($i = 1; $i <= 5; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        aria-label="رقم {{ $i }}"
                        autocomplete="{{ $i === 1 ? 'one-time-code' : 'off' }}"
                    >
                @endfor
            </div>

            <div
                class="err"
                id="otp-err"
                style="text-align: center"
            ></div>

            <p class="timer">
                <span id="t">۰۲:۰۰</span>

                <x-client.link
                    id="resend"
                    hidden
                >
                    ارسال مجدد کد
                </x-client.link>
            </p>

            <x-client.button
                type="submit"
                class="w-100"
                id="verify-code"
            >
                تأیید کد
            </x-client.button>
        </form>

        {{-- مرحله سوم: رمز عبور جدید --}}
        <form
            novalidate
            id="f3"
            style="display: none"
        >
            <x-client.forms.input
                id="f-pass"
                name="password"
                type="password"
                label="رمز عبور جدید"
                placeholder="حداقل ۸ کاراکتر"
                autocomplete="new-password"
            />

            <x-client.forms.input
                id="f-pass-confirmation"
                name="password_confirmation"
                type="password"
                label="تکرار رمز عبور"
                placeholder="تکرار رمز عبور"
                autocomplete="new-password"
            />

            <div
                class="err"
                id="password-err"
                style="text-align: center"
            ></div>

            <x-client.button
                type="submit"
                class="w-100"
                id="reset-password"
            >
                تغییر رمز عبور
            </x-client.button>
        </form>

        <p class="switch">
            <x-client.link href="{{ route('login') }}">
                بازگشت به ورود
            </x-client.link>
        </p>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            'use strict';

            const $formPhone = $('#f1');
            const $formOtp = $('#f2');
            const $formPassword = $('#f3');

            const $phone = $('#f-phone');
            const $notice = $('#f-notice');

            const $otpError = $('#otp-err');
            const $passwordError = $('#password-err');

            const $password = $('#f-pass');
            const $passwordConfirmation = $('#f-pass-confirmation');

            const $timer = $('#t');
            const $resend = $('#resend');

            const $otpInputs = $('#otp input');

            const sendCodeUrl = @json(route('password.code.send'));
            const verifyCodeUrl = @json(route('password.code.verify'));
            const resetPasswordUrl = @json(route('password.reset'));
            const loginUrl = @json(route('login'));

            let phone = null;

            let timer = null;
            let remainingSeconds = 0;

            /**
             * تبدیل اعداد انگلیسی به فارسی
             */
            function toPersianNumber(number) {
                return String(number).replace(
                    /\d/g,
                    function (digit) {
                        return '۰۱۲۳۴۵۶۷۸۹'[digit];
                    }
                );
            }

            /**
             * نمایش زمان
             */
            function updateTimer() {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;

                $timer.text(
                    toPersianNumber(
                        String(minutes).padStart(2, '0') +
                        ':' +
                        String(seconds).padStart(2, '0')
                    )
                );
            }

            /**
             * شروع تایمر
             */
            function startTimer() {
                clearInterval(timer);

                remainingSeconds = 120;

                $resend.attr('hidden', true);

                updateTimer();

                timer = setInterval(function () {
                    remainingSeconds--;

                    updateTimer();

                    if (remainingSeconds <= 0) {
                        clearInterval(timer);

                        timer = null;

                        $timer.text('۰۰:۰۰');

                        $resend.removeAttr('hidden');
                    }
                }, 1000);
            }

            /**
             * نمایش مرحله OTP
             */
            function showOtpStep() {
                $formPhone.hide();
                $formPassword.hide();

                $formOtp.show();

                $otpError.text('');
                $passwordError.text('');

                $otpInputs.val('');

                startTimer();

                $otpInputs.first().trigger('focus');
            }

            /**
             * نمایش مرحله رمز عبور
             */
            function showPasswordStep() {
                clearInterval(timer);

                timer = null;

                $formPhone.hide();
                $formOtp.hide();

                $formPassword.show();

                $otpError.text('');
                $passwordError.text('');

                $password.trigger('focus');
            }

            /**
             * برگشت به مرحله شماره موبایل
             */
            function showPhoneStep() {
                clearInterval(timer);

                timer = null;

                phone = null;

                $formOtp.hide();
                $formPassword.hide();

                $formPhone.show();

                $otpInputs.val('');

                $password.val('');
                $passwordConfirmation.val('');

                $otpError.text('');
                $passwordError.text('');

                $timer.text('۰۲:۰۰');

                $resend.attr('hidden', true);

                $phone.trigger('focus');
            }

            /**
             * دریافت کد OTP
             */
            function getOtp() {
                let otp = '';

                $otpInputs.each(function () {
                    otp += $(this).val();
                });

                return otp;
            }

            /**
             * فقط عدد در OTP
             */
            $otpInputs.on('input', function () {
                const value = $(this)
                    .val()
                    .replace(/\D/g, '');

                $(this).val(value);

                if (value.length === 1) {
                    const index = $otpInputs.index(this);

                    if (index < $otpInputs.length - 1) {
                        $otpInputs
                            .eq(index + 1)
                            .trigger('focus');
                    }
                }

                $otpError.text('');
            });

            /**
             * برگشت با Backspace
             */
            $otpInputs.on('keydown', function (event) {
                if (
                    event.key === 'Backspace' &&
                    $(this).val() === ''
                ) {
                    const index = $otpInputs.index(this);

                    if (index > 0) {
                        $otpInputs
                            .eq(index - 1)
                            .trigger('focus');
                    }
                }
            });

            /**
             * ارسال کد تأیید
             */
            $formPhone.on('submit', function (event) {
                event.preventDefault();

                const $button = $('#send-code');

                const phoneValue = $phone.val().trim();

                $notice.text('');

                if (!phoneValue) {
                    $notice.text(
                        'لطفاً شماره موبایل خود را وارد کنید.'
                    );

                    return;
                }

                $button.prop('disabled', true);

                Ajax.post(sendCodeUrl, {
                    phone: phoneValue,
                })
                    .done(function (response) {
                        phone = phoneValue;

                        toast.success(response.message);

                        showOtpStep();
                    })
                    .fail(function (xhr) {
                        const response = xhr.responseJSON;

                        // toast.error(response?.message ||
                        //     'ارسال کد تأیید با خطا مواجه شد.');

                        $notice.show();
                        $notice.text(
                            response?.message ||
                            'ارسال مجدد کد با خطا مواجه شد.'
                        );
                    })
                    .always(function () {
                        $button.prop('disabled', false);
                    });
            });

            /**
             * ارسال مجدد کد
             */
            $resend.on('click', function (event) {
                event.preventDefault();

                if (!phone) {
                    showPhoneStep();

                    return;
                }

                $resend.attr('hidden', true);

                $otpError.text('');

                Ajax.post(sendCodeUrl, {
                    phone: phone,
                })
                    .done(function (response) {
                        $otpInputs.val('');

                        startTimer();

                        $otpInputs
                            .first()
                            .trigger('focus');

                        toast.success(response.message);

                        if (response.message) {
                            $notice.text(response.message);
                        }
                    })
                    .fail(function (xhr) {
                        const response = xhr.responseJSON;

                        $resend.removeAttr('hidden');

                        $otpError.text(
                            response?.message ||
                            'ارسال مجدد کد با خطا مواجه شد.'
                        );
                    });
            });

            /**
             * تأیید کد OTP
             */
            $formOtp.on('submit', function (event) {
                event.preventDefault();

                const $button = $('#verify-code');

                const otp = getOtp();

                $otpError.text('');

                if (otp.length !== $otpInputs.length) {
                    $otpError.text(
                        'لطفاً کد تأیید را کامل وارد کنید.'
                    );

                    return;
                }

                if (!phone) {
                    showPhoneStep();

                    return;
                }

                $button.prop('disabled', true);

                Ajax.post(verifyCodeUrl, {
                    phone: phone,
                    code: otp,
                })
                    .done(function (response) {
                        toast.success(response.message);

                        showPasswordStep();

                        if (response.message) {
                            $notice.text(response.message);
                        }
                    })
                    .fail(function (xhr) {
                        const response = xhr.responseJSON;

                        $otpError.text(
                            response?.message ||
                            'کد تأیید صحیح نیست.'
                        );
                    })
                    .always(function () {
                        $button.prop('disabled', false);
                    });
            });

            /**
             * تغییر رمز عبور
             */
            $formPassword.on('submit', function (event) {
                event.preventDefault();

                const $button = $('#reset-password');

                const password = $password.val();
                const passwordConfirmation =
                    $passwordConfirmation.val();

                $passwordError.text('');

                if (!password) {
                    $passwordError.text(
                        'لطفاً رمز عبور جدید را وارد کنید.'
                    );

                    return;
                }

                if (password.length < 8) {
                    $passwordError.text(
                        'رمز عبور باید حداقل ۸ کاراکتر باشد.'
                    );

                    return;
                }

                if (!passwordConfirmation) {
                    $passwordError.text(
                        'لطفاً تکرار رمز عبور را وارد کنید.'
                    );

                    return;
                }

                if (password !== passwordConfirmation) {
                    $passwordError.text(
                        'تکرار رمز عبور با رمز عبور یکسان نیست.'
                    );

                    return;
                }

                if (!phone) {
                    showPhoneStep();

                    return;
                }

                $button.prop('disabled', true);

                Ajax.post(resetPasswordUrl, {
                    password: password,
                    password_confirmation: passwordConfirmation,
                })
                    .done(function (response) {
                        toast.success(
                            response.message ||
                            'رمز عبور با موفقیت تغییر کرد.'
                        );

                        window.location.href =
                            response.redirect || loginUrl;
                    })
                    .fail(function (xhr) {
                        const response = xhr.responseJSON;

                        $passwordError.text(
                            response?.message ||
                            'تغییر رمز عبور با خطا مواجه شد.'
                        );
                    })
                    .always(function () {
                        $button.prop('disabled', false);
                    });
            });
        })();
    </script>
@endpush

