
/**
 * =============================================================
 * Authentication
 * =============================================================
 */

(function () {
    'use strict';

    /**
     * =========================================================
     * DOM Helpers
     * =========================================================
     */

    const select = (selector, root = document) =>
        root.querySelector(selector);

    const selectAll = (selector, root = document) =>
        [...root.querySelectorAll(selector)];


    /**
     * =========================================================
     * View
     * =========================================================
     */

    const titles = {
        login: 'ورود',
        register: 'ثبت‌نام',
        forgot: 'فراموشی رمز عبور',
        otp: 'تأیید شماره موبایل',
        reset: 'تغییر رمز عبور',
    };

    function go(view) {
        selectAll('[data-view]').forEach(element => {
            element.hidden = element.dataset.view !== view;
        });

        document.title = titles[view] || document.title;
    }

    selectAll('[data-go]').forEach(element => {
        element.addEventListener('click', function (event) {
            event.preventDefault();

            const view = this.dataset.go;

            if (view) {
                go(view);
            }
        });
    });

    const initialView = window.location.hash.replace('#', '');

    if (titles[initialView]) {
        go(initialView);
    }


    /**
     * =========================================================
     * Password Visibility
     * =========================================================
     */

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-password-toggle]');

        if (!button) {
            return;
        }

        const targetSelector = button.dataset.passwordToggle;
        const input = select(targetSelector);

        if (!input) {
            return;
        }

        const isPassword = input.type === 'password';

        input.type = isPassword ? 'text' : 'password';

        button.classList.toggle('active', isPassword);
    });


    /**
     * =========================================================
     * Helpers
     * =========================================================
     */

    const fa2en = value => String(value)
        .replace(/[۰-۹]/g, digit =>
            '۰۱۲۳۴۵۶۷۸۹'.indexOf(digit)
        )
        .replace(/[٠-٩]/g, digit =>
            '٠١٢٣٤٥٦٧٨٩'.indexOf(digit)
        );

    const toFa = value => String(value)
        .replace(/\d/g, digit => '۰۱۲۳۴۵۶۷۸۹'[digit]);

    const phoneOk = value =>
        /^09\d{9}$/.test(fa2en(value.trim()));


    /**
     * =========================================================
     * Validation
     * =========================================================
     */

    function setErr(input, message = '') {
        if (!input) {
            return;
        }

        const wrapper = input.closest('.form-group, .mb-3, .field');

        if (!wrapper) {
            return;
        }

        const error = wrapper.querySelector(
            '[data-error], .invalid-feedback'
        );

        input.classList.toggle('is-invalid', Boolean(message));

        if (error) {
            error.textContent = message;
        }
    }

    function check(form, rules) {
        let valid = true;
        let firstInvalid = null;

        Object.entries(rules).forEach(([name, rule]) => {
            const input = form.elements[name];

            if (!input) {
                return;
            }

            const message = rule(input);

            setErr(input, message);

            if (message && !firstInvalid) {
                firstInvalid = input;
                valid = false;
            }
        });

        if (firstInvalid) {
            firstInvalid.focus();
        }

        return valid;
    }

    const req = message => input =>
        input.value.trim()
            ? ''
            : message;

    const phoneRule = input =>
        phoneOk(input.value)
            ? ''
            : 'شماره موبایل معتبر نیست.';

    const passRule = input =>
        input.value.length >= 8
            ? ''
            : 'رمز عبور باید حداقل ۸ کاراکتر باشد.';


    /**
     * =========================================================
     * Server Validation Errors
     * =========================================================
     */

    function showServerErrors(form, errors = {}) {
        let firstInvalid = null;

        Object.entries(errors).forEach(([name, messages]) => {
            const input = form.elements[name];

            if (!input) {
                return;
            }

            const message = Array.isArray(messages)
                ? messages[0]
                : messages;

            setErr(input, message);

            if (!firstInvalid) {
                firstInvalid = input;
            }
        });

        if (firstInvalid) {
            firstInvalid.focus();
        }
    }


    /**
     * =========================================================
     * Submit State
     * =========================================================
     */

    function submitting(button, loadingText) {
        if (!button) {
            return;
        }

        button.disabled = true;
        button.dataset.oldText = button.textContent;
        button.textContent = loadingText;
    }

    function submitted(button) {
        if (!button) {
            return;
        }

        button.disabled = false;
        button.textContent = button.dataset.oldText || button.textContent;
    }


    /**
     * =========================================================
     * Login
     * =========================================================
     */

    const loginForm = select('[data-form="login"]');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const button = form.querySelector('.btn');

            if (!check(form, {
                phone: phoneRule,

                password: req(
                    'رمز عبور را وارد کنید.'
                ),
            })) {
                return;
            }

            submitting(button, 'در حال ورود...');

            Ajax.post('/auth/login', {
                phone: fa2en(
                    form.elements.phone.value.trim()
                ),

                password: form.elements.password.value,
            })
                .done(function (response) {
                    window.location.href =
                        response.redirect || '/';
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        showServerErrors(
                            form,
                            xhr.responseJSON?.errors || {}
                        );

                        return;
                    }

                    toast.error(
                        xhr.responseJSON?.message ||
                        'ورود انجام نشد. دوباره تلاش کنید.'
                    );
                })
                .always(function () {
                    submitted(button);
                });
        });
    }


    /**
     * =========================================================
     * Register
     * =========================================================
     */

    const registerPassword = select('#r-pass');

    if (registerPassword) {
        registerPassword.addEventListener('input', function (event) {
            const value = event.target.value;

            let score = 0;

            if (value.length >= 8) {
                score++;
            }

            if (/[A-Za-z]/.test(value) && /\d/.test(value)) {
                score++;
            }

            if (
                /[^A-Za-z0-9]/.test(value) ||
                value.length >= 12
            ) {
                score++;
            }

            const bar = select('#bar');

            if (!bar) {
                return;
            }

            bar.style.width = value
                ? `${(score + 1) * 25}%`
                : '0%';

            bar.style.background = [
                'var(--danger)',
                'var(--danger)',
                'var(--amber)',
                'var(--ok)',
            ][score];
        });
    }

    const registerForm = select('[data-form="register"]');

    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const button = form.querySelector('.btn');

            if (!check(form, {
                user_name: req(
                    'نام را وارد کنید.'
                ),

                phone: phoneRule,

                password: passRule,

                password_confirmation: input =>
                    input.value !==
                    form.elements.password.value
                        ? 'تکرار رمز عبور با رمز اصلی یکسان نیست.'
                        : '',

                terms: input =>
                    input.checked
                        ? ''
                        : 'برای ادامه باید قوانین را بپذیرید.',
            })) {
                return;
            }

            submitting(
                button,
                'در حال ثبت‌نام...'
            );

            Ajax.post('/auth/register', {
                user_name:
                    form.elements.user_name.value.trim(),

                phone:
                    fa2en(
                        form.elements.phone.value.trim()
                    ),

                password:
                    form.elements.password.value,

                password_confirmation:
                    form.elements.password_confirmation.value,

                terms:
                    form.elements.terms.checked,
            })
                .done(function (response) {
                    window.location.href =
                        response.redirect || '/';
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        showServerErrors(
                            form,
                            xhr.responseJSON?.errors || {}
                        );

                        return;
                    }

                    toast.error(
                        xhr.responseJSON?.message ||
                        'ثبت‌نام انجام نشد. دوباره تلاش کنید.'
                    );
                })
                .always(function () {
                    submitted(button);
                });
        });
    }


    /**
     * =========================================================
     * Forgot Password
     * =========================================================
     */

    const forgotForm = select('[data-form="forgot"]');

    if (forgotForm) {
        forgotForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const button = form.querySelector('.btn');

            if (!check(form, {
                phone: phoneRule,
            })) {
                return;
            }

            submitting(
                button,
                'در حال ارسال...'
            );

            Ajax.post('/forgot-password', {
                phone: fa2en(
                    form.elements.phone.value.trim()
                ),
            })
                .done(function (response) {
                    if (response.redirect) {
                        window.location.href =
                            response.redirect;

                        return;
                    }

                    go('otp');

                    toast.success(
                        response.message ||
                        'کد تأیید ارسال شد.'
                    );
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        showServerErrors(
                            form,
                            xhr.responseJSON?.errors || {}
                        );

                        return;
                    }

                    toast.error(
                        xhr.responseJSON?.message ||
                        'ارسال کد انجام نشد.'
                    );
                })
                .always(function () {
                    submitted(button);
                });
        });
    }


    /**
     * =========================================================
     * Resend OTP
     * =========================================================
     */

    const resendButton = select('[data-resend-otp]');

    if (resendButton) {
        resendButton.addEventListener('click', function () {
            const phoneInput =
                select('[data-form="otp"] [name="phone"]') ||
                select('[name="phone"]');

            if (!phoneInput) {
                return;
            }

            resendButton.disabled = true;

            Ajax.post('/forgot-password/resend', {
                phone: fa2en(
                    phoneInput.value.trim()
                ),
            })
                .done(function (response) {
                    toast.success(
                        response.message ||
                        'کد تأیید مجدداً ارسال شد.'
                    );
                })
                .fail(function (xhr) {
                    toast.error(
                        xhr.responseJSON?.message ||
                        'ارسال مجدد کد انجام نشد.'
                    );
                })
                .always(function () {
                    resendButton.disabled = false;
                });
        });
    }


    /**
     * =========================================================
     * OTP
     * =========================================================
     */

    const otpForm = select('[data-form="otp"]');

    if (otpForm) {
        const otpInputs = selectAll(
            '[data-form="otp"] input[data-otp]'
        );

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                this.value = fa2en(this.value)
                    .replace(/\D/g, '')
                    .slice(0, 1);

                if (
                    this.value &&
                    otpInputs[index + 1]
                ) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (event) {
                if (
                    event.key === 'Backspace' &&
                    !this.value &&
                    otpInputs[index - 1]
                ) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        otpForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const button = form.querySelector('.btn');

            const otp = otpInputs
                .map(input => input.value)
                .join('');

            if (otp.length !== otpInputs.length) {
                toast.error(
                    'کد تأیید را کامل وارد کنید.'
                );

                return;
            }

            submitting(
                button,
                'در حال بررسی...'
            );

            Ajax.post('/verify-otp', {
                otp: otp,
            })
                .done(function (response) {
                    if (response.redirect) {
                        window.location.href =
                            response.redirect;

                        return;
                    }

                    go('reset');

                    toast.success(
                        response.message ||
                        'کد تأیید شد.'
                    );
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        showServerErrors(
                            form,
                            xhr.responseJSON?.errors || {}
                        );

                        return;
                    }

                    toast.error(
                        xhr.responseJSON?.message ||
                        'کد تأیید نامعتبر است.'
                    );
                })
                .always(function () {
                    submitted(button);
                });
        });
    }


    /**
     * =========================================================
     * Reset Password
     * =========================================================
     */

    const resetForm = select('[data-form="reset"]');

    if (resetForm) {
        resetForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const form = event.target;
            const button = form.querySelector('.btn');

            if (!check(form, {
                password: passRule,

                password_confirmation: input =>
                    input.value !==
                    form.elements.password.value
                        ? 'تکرار رمز عبور با رمز اصلی یکسان نیست.'
                        : '',
            })) {
                return;
            }

            submitting(
                button,
                'در حال تغییر رمز...'
            );

            Ajax.post('/reset-password', {
                password:
                    form.elements.password.value,

                password_confirmation:
                    form.elements.password_confirmation.value,
            })
                .done(function (response) {
                    toast.success(
                        response.message ||
                        'رمز عبور با موفقیت تغییر کرد.'
                    );

                    window.location.href =
                        response.redirect || '/';
                })
                .fail(function (xhr) {
                    if (xhr.status === 422) {
                        showServerErrors(
                            form,
                            xhr.responseJSON?.errors || {}
                        );

                        return;
                    }

                    toast.error(
                        xhr.responseJSON?.message ||
                        'تغییر رمز عبور انجام نشد.'
                    );
                })
                .always(function () {
                    submitted(button);
                });
        });
    }

})();

