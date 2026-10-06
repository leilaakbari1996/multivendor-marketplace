
$(document).on('submit', '.newsletter-form', function (event) {
    event.preventDefault();

    const form = $(this);
    const button = form.find('button[type="submit"]');

    button.prop('disabled', true);

    Ajax.post(
        form.attr('action'),
        form.serialize()
    )
        .done(function (response) {
            form[0].reset();

            toast.success(response.message);
        })
        .fail(function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors;

                if (errors) {
                    const firstError = Object.values(errors)[0][0];

                    toast.error(firstError);

                    return;
                }
            }

            alertError(
                'خطا',
                'در هنگام ثبت عضویت مشکلی پیش آمد.'
            );
        })
        .always(function () {
            button.prop('disabled', false);
        });
});

