(function ($) {
    'use strict';

    const MAX_FALLBACK = 20;

    // ---------- Helpers ----------

    function toFa(number) {
        return Number(number).toLocaleString('fa-IR');
    }

    function showErrors(xhr) {
        if (xhr.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (xhr.status === 422) {
            const errors = (xhr.responseJSON && xhr.responseJSON.errors) || {};
            const message = Object.values(errors).flat().join(' ');
            toast.error(message || 'اطلاعات واردشده معتبر نیست.');
            return;
        }

        if (xhr.status === 404) {
            toast.error('این محصول در سبد شما یافت نشد.');
            return;
        }

        console.error('Cart error:', xhr);
        toast.error('خطایی رخ داد. دوباره تلاش کنید.');
    }

    function updateCartSummary(cart) {
        $('[data-cart-count]').text(toFa(cart.count));
        $('.cart-total[data-cart-total]').text(toFa(cart.total) + ' تومان');

        if (cart.html) {
            $('#cartBody').html(cart.html);
        }
    }

    function openCart() {
        const $el = $('#offcanvasCart');

        if ($el.length && window.bootstrap) {
            bootstrap.Offcanvas.getOrCreateInstance($el[0]).show();
        }
    }

    function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
    }

    // ---------- کارت محصول: + و − ----------

    $(document).on('click', '.btn-number', function () {
        const $button = $(this);
        const $input = $button.closest('.product-qty').find('.input-number');

        if (!$input.length) return;

        const step = $button.data('type') === 'plus' ? 1 : -1;
        const current = parseInt($input.val(), 10);
        const value = Number.isNaN(current) ? 0 : current;
        const max = parseInt($input.attr('max'), 10) || Infinity;

        $input.val(clamp(value + step, 0, max));
    });

    // ---------- افزودن به سبد ----------

    $(document).on('click', '[data-cart]', function () {
        const $button = $(this);
        const productId = $button.data('product-id');

        if (!productId) return;

        const $qty = $button.closest('.product-item').find('.input-number');
        const quantity = $qty.length ? (parseInt($qty.val(), 10) || 1) : 1;

        $button.prop('disabled', true);

        Ajax.post('/cart/items', {
            product_id: productId,
            quantity: quantity,
        })
            .done(function (response) {
                toast.success(response.message);
                updateCartSummary(response.cart);
                $(`.pd-buy-${productId} .input-number`).val(quantity);
                openCart();
            })
            .fail(showErrors)
            .always(function () {
                $button.prop('disabled', false);
            });
    });

    // ---------- آفکنوس: + و − ----------

    $(document).on('click', '#cartBody [data-qty-minus], #cartBody [data-qty-plus]', function () {
        const $button = $(this);
        const $input = $button.closest('.input-group').find('input[type="number"]');

        const step = $button.is('[data-qty-plus]') ? 1 : -1;
        const min = parseInt($input.attr('min'), 10) || 0;
        const max = parseInt($input.attr('max'), 10) || MAX_FALLBACK;
        const current = parseInt($input.val(), 10) || 0;

        $input.val(clamp(current + step, min, max));
    });

    // ---------- آفکنوس: بروزرسانی و حذف ----------

    $(document).on('submit', '#cartBody form', function (e) {
        e.preventDefault();
        const $form = $(this);
        const action = $form.attr('action');
        if (!action) return;

        const method = ($form.find('input[name="_method"]').val() || 'POST').toUpperCase();
        const $submit = $form.find('button[type="submit"]');

        $submit.prop('disabled', true);

        let request;

        if (method === 'PATCH') {
            request = Ajax.patch(action, {
                quantity: $form.find('input[name="quantity"]').val(),
            });
        } else if (method === 'DELETE') {
            request = Ajax.delete(action);
        } else {
            request = Ajax.post(action, $form.serialize());
        }

        request
            .done(function (response) {
                toast.success(response.message);
                updateCartSummary(response.cart);
                console.log(response)
                console.log(method)
                if (method === 'DELETE')
                {
                    console.log('ok')
                    let productId = $form.data('productId');

                    console.log(productId)
                    $(`.pd-buy-${productId} .input-number`).val(0);
                }
            })
            .fail(showErrors)
            .always(function () {
                $submit.prop('disabled', false);
            });
    });



})(jQuery);

