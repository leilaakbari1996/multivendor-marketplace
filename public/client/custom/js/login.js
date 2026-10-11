(function () {
    'use strict';

    const form = document.querySelector(
        '[data-form="login"]'
    );

    if (!form) {
        return;
    }

    const button = form.querySelector(
        'button[type="submit"]'
    );

    const phone = form.elements.phone;
    const password = form.elements.password;
    const remember = form.elements.remember;


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

            button.dataset.oldText =
                button.textContent;

            button.textContent = 'در حال ورود...';

            return;
        }

        button.disabled = false;

        button.textContent =
            button.dataset.oldText ||
            button.textContent;
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
         * =====================================================
         * شماره موبایل
         * =====================================================
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
         * =====================================================
         * رمز عبور
         * =====================================================
         */

        if (!password.value) {
            setError(
                password,
                'رمز عبور را وارد کنید.'
            );

            valid = false;
            firstInvalid ||= password;
        }


        /**
         * =====================================================
         * Validation Result
         * =====================================================
         */

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

        Ajax.post('login', {
            phone: fa2en(
                phone.value.trim()
            ),

            password: password.value,

            remember: remember?.checked ?? false,
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

                    toast.error(
                        'اطلاعات واردشده صحیح نیست. لطفاً فیلدها را بررسی کنید.'
                    );

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
                    'ورود انجام نشد. دوباره تلاش کنید.'
                );
            })

            .always(function () {
                setLoading(false);
            });
    });

})();
