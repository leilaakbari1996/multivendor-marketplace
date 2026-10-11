/**
 * =============================================================
 * Orders page – فیلتر وضعیت و صفحه‌بندی بدون رفرش (AJAX)
 * =============================================================
 * وابستگی: jQuery و Ajax (ajax.js) که باید قبل از این فایل لود شوند.
 *
 * DEBUG = true  => هنگام خطا، به صفحه ریدایرکت نمی‌کند و خطا را در Console می‌نویسد.
 * بعد از اینکه همه‌چیز درست کار کرد، DEBUG را false کن.
 */
(function () {
    const DEBUG = true;

    console.info('[orders.js] loaded');

    if (!window.jQuery || !window.Ajax) {
        console.error('[orders.js] jQuery یا Ajax لود نشده؛ ترتیب اسکریپت‌ها را بررسی کن.', {
            jQuery: !!window.jQuery,
            Ajax: !!window.Ajax,
        });
        return; // لینک‌ها مثل قبل (با رفرش) کار می‌کنند
    }

    jQuery(function ($) {
        const $card  = $('#orders-card');
        const $list  = $('#orders-list');
        const $count = $('#orders-count');
        const $tabs  = $('#orders-filters .nav-link');

        if (!$list.length) {
            console.error('[orders.js] المان #orders-list پیدا نشد؛ ویوی index جدید را جایگزین کرده‌ای؟');
            return;
        }

        let currentRequest = null;

        /** تب فعال را بر اساس ?status= آدرس تنظیم می‌کند */
        function syncActiveTab(url) {
            const status = new URL(url, window.location.origin).searchParams.get('status') ?? '';

            $tabs.each(function () {
                $(this).toggleClass('active', String($(this).attr('data-status') ?? '') === status);
            });
        }

        /** لیست را از سرور می‌گیرد و جایگزین می‌کند */
        function loadOrders(url, { push = true, scroll = false } = {}) {
            // درخواست قبلی هنوز در جریان است؟ لغوش کن (کلیک‌های پشت‌سرهم)
            if (currentRequest) {
                currentRequest.abort();
            }

            $list.addClass('is-loading');

            currentRequest = Ajax.get(url)
                .done(function (res) {
                    if (!res || typeof res.html !== 'string') {
                        console.error('[orders.js] پاسخ سرور JSON معتبر با کلید html نیست:', res);
                        return;
                    }

                    $list.html(res.html);
                    $count.text(res.total + ' سفارش');
                    syncActiveTab(url);

                    if (push) {
                        window.history.pushState({ orders: true }, '', url);
                    }

                    if (scroll) {
                        $card[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                })
                .fail(function (xhr, textStatus) {
                    if (textStatus === 'abort') {
                        return; // لغو عمدی
                    }

                    console.error('[orders.js] درخواست AJAX ناموفق بود', xhr.status, textStatus, xhr.responseText);

                    if (!DEBUG) {
                        window.location.href = url; // fallback: ناوبری معمولی
                    }
                })
                .always(function () {
                    $list.removeClass('is-loading');
                });
        }

        // کلیک روی تب‌های وضعیت و لینک‌های صفحه‌بندی
        $(document).on('click', '#orders-filters .nav-link, #orders-list .pagination a', function (e) {
            // Ctrl/Cmd/Shift/کلیک وسط: بگذار مرورگر در تب جدید باز کند
            if (e.ctrlKey || e.metaKey || e.shiftKey || e.which === 2) {
                return;
            }

            e.preventDefault();

            const isPagination = $(this).closest('.pagination').length > 0;
            loadOrders(this.href, { scroll: isPagination });
        });

        // دکمه Back / Forward مرورگر
        window.addEventListener('popstate', function () {
            loadOrders(window.location.href, { push: false });
        });
    });
})();
