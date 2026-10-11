
(function () {
    'use strict';

    const form = document.querySelector(
        '[data-form="register"]'
    );

    if (!form) {
        return;
    }

    const button = form.querySelector(
        'button[type="submit"]'
    );

    const userName = form.elements.user_name;
    const phone = form.elements.phone;
    const password = form.elements.password;
    const passwordConfirmation =
        form.elements.password_confirmation;
    const terms = form.elements.terms;

    const passwordBar = document.querySelector('#bar');


    /**
     * =========================================================
     * Helpers
     * =========================================================
     */

    function fa2en(value) {
        return String(value)
            .replace(/[۰-۹]/g, digit =>
                '۰۱۲۳۴۵۶۷۸۹'.indexOf(digit)
            )
            .replace(/[٠-٩]/g, digit =>
                '٠١٢٣٤٥٦٧٨٩'.indexOf(digit)
            );
    }

    function isValidPhone(value) {
        return /^09\d{9}$/.test(
            fa2en(value.trim())
        );
    }


    /**
     * =========================================================
     * Error
     * =========================================================
     */

    function setError(input, message = '') {
        const field = input.closest('.field');

        if (!field) {
            return;
        }

        const error = field.querySelector('.err');

        input.classList.toggle(
            'invalid',
            Boolean(message)
        );

        if (error) {
            error.textContent = message;
            error.classList.toggle(
                'show',
                Boolean(message)
            );
        }
    }

    function clearErrors() {
        form.querySelectorAll('.field input').forEach(input => {
            input.classList.remove('invalid');
        });

        form.querySelectorAll('.field .err').forEach(error => {
            error.textContent = '';
            error.classList.remove('show');
        });
    }


    /**
     * =========================================================
     * Loading
     * =========================================================
     */

    function setLoading(loading) {
        if (!button) {
            return;
        }

        if (loading) {
            button.disabled = true;
            button.dataset.oldText = button.textContent;
            button.textContent = 'در حال ثبت‌نام...';

            return;
        }

        button.disabled = false;
        button.textContent =
            button.dataset.oldText || button.textContent;
    }


    /**
     * =========================================================
     * Password Strength
     * =========================================================
     */

    if (password && passwordBar) {
        password.addEventListener('input', function () {
            const value = this.value;

            let score = 0;

            if (value.length >= 8) {
                score++;
            }

            if (
                /[A-Za-z]/.test(value) &&
                /\d/.test(value)
            ) {
                score++;
            }

            if (
                /[^A-Za-z0-9]/.test(value) ||
                value.length >= 12
            ) {
                score++;
            }

            passwordBar.style.width = value
                ? `${(score + 1) * 25}%`
                : '0%';

            passwordBar.style.background = [
                'var(--danger)',
                'var(--danger)',
                'var(--amber)',
                'var(--ok)',
            ][score];
        });
    }


    /**
     * =========================================================
     * Submit
     * =========================================================
     */

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        clearErrors();

        let valid = true;
        let firstInvalid = null;


        /**
         * نام کاربری
         */
        if (!userName.value.trim()) {
            setError(
                userName,
                'نام کاربری را وارد کنید.'
            );

            valid = false;
            firstInvalid ||= userName;
        }


        /**
         * شماره موبایل
         */
        if (!isValidPhone(phone.value)) {
            setError(
                phone,
                'شماره موبایل معتبر نیست.'
            );

            valid = false;
            firstInvalid ||= phone;
        }


        /**
         * رمز عبور
         */
        if (!password.value) {
            setError(
                password,
                'رمز عبور را وارد کنید.'
            );

            valid = false;
            firstInvalid ||= password;
        } else if (password.value.length < 8) {
            setError(
                password,
                'رمز عبور باید حداقل ۸ کاراکتر باشد.'
            );

            valid = false;
            firstInvalid ||= password;
        }


        /**
         * تکرار رمز عبور
         */
        if (!passwordConfirmation.value) {
            setError(
                passwordConfirmation,
                'تکرار رمز عبور را وارد کنید.'
            );

            valid = false;
            firstInvalid ||= passwordConfirmation;
        } else if (
            passwordConfirmation.value !== password.value
        ) {
            setError(
                passwordConfirmation,
                'تکرار رمز عبور با رمز اصلی یکسان نیست.'
            );

            valid = false;
            firstInvalid ||= passwordConfirmation;
        }


        /**
         * قوانین
         */
        if (!terms.checked) {
            const field = terms.closest('.field');
            const error = field?.querySelector('.err');

            if (error) {
                error.textContent =
                    'برای ادامه باید قوانین و مقررات را بپذیرید.';

                error.classList.add('show');
            }

            valid = false;
            firstInvalid ||= terms;
        }


        if (!valid) {
            firstInvalid?.focus();

            return;
        }


        /**
         * =====================================================
         * AJAX
         * =====================================================
         */

        setLoading(true);

        Ajax.post('register', {
            user_name: userName.value.trim(),

            phone: fa2en(
                phone.value.trim()
            ),

            password: password.value,

            password_confirmation:
                passwordConfirmation.value,

            terms: terms.checked,
        })
            .done(function (response) {
                toast.success(response.message);

                setTimeout(function () {
                    window.location.href =
                        response.redirect || '/';
                }, 1000);
            })
            .fail(function (xhr) {
                if (xhr.status === 422) {
                    const errors =
                        xhr.responseJSON?.errors || {};

                    toast.error('اطلاعات واردشده صحیح نیست. لطفاً فیلدها را بررسی کنید.');

                    Object.entries(errors).forEach(
                        ([name, messages]) => {
                            const input =
                                form.elements[name];

                            if (!input) {
                                return;
                            }

                            setError(
                                input,
                                Array.isArray(messages)
                                    ? messages[0]
                                    : messages
                            );
                        }
                    );

                    return;
                }

                toast.error(
                    xhr.responseJSON?.message ||
                    'ثبت‌نام انجام نشد. دوباره تلاش کنید.'
                );
            })
            .always(function () {
                setLoading(false);
            });
    });

})();

