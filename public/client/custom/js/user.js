(function () {
    const input = document.getElementById('avatarInput');
    const form = document.getElementById('avatarForm');
    const preview = document.getElementById('avatarPreview');
    const placeholder = document.getElementById('avatarPlaceholder');
    const badge = document.querySelector('.sidebar-avatar-badge');

    if (!input || !form || !preview) return;

    const MAX_SIZE = 2 * 1024 * 1024;
    const ALLOWED = ['image/png', 'image/jpeg', 'image/webp'];

    let isUploading = false;
    let tempUrl = null;

    // اگه Toast داری اینجا وصلش کن، مثلاً: Toast.error(message)

    const revokeTempUrl = () => {
        if (tempUrl) {
            URL.revokeObjectURL(tempUrl);
            tempUrl = null;
        }
    };

    const setLoading = (state) => {
        isUploading = state;
        badge?.classList.toggle('is-loading', state);
        input.disabled = state;
    };

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file || isUploading) return;

        if (!ALLOWED.includes(file.type)) {
            toast.error('فرمت‌های مجاز: JPG، PNG، WEBP.');
            this.value = '';
            return;
        }

        if (file.size > MAX_SIZE) {
            toast.error('حجم عکس نباید بیشتر از ۲ مگابایت باشه.');
            this.value = '';
            return;
        }

        // ذخیره‌ی وضعیت قبلی برای برگردوندن در صورت خطا
        const oldSrc = preview.getAttribute('src');
        const wasHidden = preview.classList.contains('d-none');

        // پیش‌نمایش فوری
        revokeTempUrl();
        tempUrl = URL.createObjectURL(file);
        preview.src = tempUrl;
        preview.classList.remove('d-none');
        placeholder?.classList.add('d-none');


        // POST + _method=PUT و _token از داخل فرم می‌آد
        const formData = new FormData(form);
        setLoading(true);

        Ajax.post(form.getAttribute('action'), formData, {
            processData: false,
            contentType: false,
        })
            .done(function (res) {
                if (res && res.url) {
                    preview.src = res.url;
                }
                toast.success(res.message);
                revokeTempUrl();
            })
            .fail(function (xhr) {
                // برگردوندن حالت قبلی
                if (oldSrc) {
                    preview.src = oldSrc;
                } else {
                    preview.removeAttribute('src');
                }

                if (wasHidden) {
                    preview.classList.add('d-none');
                    placeholder?.classList.remove('d-none');
                }
                revokeTempUrl();

                const msg = xhr.responseJSON?.errors?.avatar?.[0]
                    || xhr.responseJSON?.message
                    || 'آپلود عکس با مشکل مواجه شد.';
                toast.error(msg);
            })
            .always(function () {
                setLoading(false);
                input.value = '';
            });
    });
})();


$(document).on('submit', '#profileForm', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $form = $(this);
    const $btn = $form.find('button[type="submit"]');

    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.ajax-error').remove();
    $btn.prop('disabled', true);

    Ajax.post($form.attr('action'), $form.serialize())
        .done(function (res) {
            toast.success(res.message);
            if (res.user_name) {
                $('[data-user-name]').text(res.user_name);
                $('#avatarPlaceholder').text(res.user_name.charAt(0));
            }
        })
        .fail(function (xhr) {
            const errors = xhr.responseJSON?.errors;
            if (xhr.status === 422 && errors) {
                $.each(errors, function (field, messages) {
                    const $input = $form.find('[name="' + field + '"]');
                    $input.addClass('is-invalid');
                    toast.error(messages[0]);
                    $('<small class="text-danger d-block mt-1 ajax-error"></small>')
                        .text(messages[0])
                        .insertAfter($input);
                });
                return;
            }
            toast.error(xhr.responseJSON?.message || 'ذخیره‌ی اطلاعات با مشکل مواجه شد.');
        })
        .always(function () {
            $btn.prop('disabled', false);
        });
});


    $(document).on('submit', '#passwordForm', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $form = $(this);
    const $btn  = $form.find('button[type="submit"]');

    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.ajax-error').remove();
    $btn.prop('disabled', true);

    Ajax.post($form.attr('action'), $form.serialize())
    .done(function (res) {
        toast.success(res.message);

    // خالی‌کردن فیلدها
    $form[0].reset();

    // اگه اولین بار رمز تعیین شده، از این به بعد رمز فعلی لازمه
    if (!res.had_password) {
    $('#currentPasswordWrapper').removeClass('d-none');
    $('#passwordTitle').text('تغییر رمز عبور');
}
})
    .fail(function (xhr) {
    const errors = xhr.responseJSON?.errors;

    if (xhr.status === 422 && errors) {
    $.each(errors, function (field, messages) {
    const $input = $form.find('[name="' + field + '"]');
    $input.addClass('is-invalid');
        toast.error(messages[0]);
    $('<small class="text-danger d-block mt-1 ajax-error"></small>')
    .text(messages[0])
    .insertAfter($input);
});
    return;
}

        toast.error(xhr.responseJSON?.message || 'ذخیره‌ی رمز با مشکل مواجه شد.');
})
    .always(function () {
    $btn.prop('disabled', false);
});
});

