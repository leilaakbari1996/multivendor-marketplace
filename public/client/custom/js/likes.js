(function () {
    'use strict';

    document.addEventListener('click', function (event) {
        const button = event.target.closest('[data-like]');

        if (!button || button.disabled) {
            return;
        }

        const type = button.dataset.likeableType;
        const id = button.dataset.likeableId;

        if (!type || !id) {
            return;
        }

        button.disabled = true;

        Ajax.post('/likes/toggle', {
            likeable_type: type,
            likeable_id: id,
        })
            .done(function (response) {
                button.classList.toggle(
                    'active',
                    response.liked
                );

                toast.success(response.message);

                if (
                    !response.liked &&
                    document.querySelector('[data-page="favorites"]')
                ) {
                    const card = button.closest('[data-like-card]');

                    if (card) {
                        card.remove();
                    }
                }
            })
            .fail(function (xhr) {
                console.error(
                    'خطا در ثبت علاقه‌مندی:',
                    xhr
                );
            })
            .always(function () {
                button.disabled = false;
            });
    });
})();
