/**
 * =============================================================
 * Live Search – پیشنهاد زنده محصولات هنگام تایپ
 * =============================================================
 * وابستگی: jQuery و Ajax (ajax.js) که باید قبل از این فایل لود شوند.
 *
 * - تأخیر ۲۵۰ms بعد از آخرین کلید (debounce) و لغو درخواست قبلی
 * - کش نتایج: تایپِ دوباره‌ی یک عبارت، درخواست جدید نمی‌زند
 * - کیبورد: ↑ ↓ حرکت، Enter رفتن به گزینه، Esc بستن، «/» فوکوس روی جستجو
 * - Enter بدون انتخاب گزینه => فرم GET عادی (صفحه محصولات با ?search=)
 */
(function () {
    if (!window.jQuery || !window.Ajax) {
        console.error('[search.js] jQuery یا Ajax لود نشده؛ ترتیب اسکریپت‌ها را بررسی کن.');
        return;
    }

    jQuery(function ($) {
        const $box = $('#site-search');
        if (!$box.length) return;

        const $input = $box.find('input[name="search"]');
        const $panel = $box.find('.search-panel');
        const url    = $box.data('url');

        const MIN_CHARS = 2;
        const DELAY     = 250;

        const cache = new Map();
        let timer   = null;
        let request = null;
        let active  = -1;

        const fa = (n) => Number(n).toLocaleString('fa-IR');

        const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
        }[c]));

        /** قسمت مطابق عبارت را پررنگ می‌کند (همه‌چیز escape می‌شود، پس امن است) */
        function mark(text, term) {
            const i = term ? text.toLowerCase().indexOf(term.toLowerCase()) : -1;
            if (i < 0) return esc(text);

            return esc(text.slice(0, i))
                + '<mark>' + esc(text.slice(i, i + term.length)) + '</mark>'
                + esc(text.slice(i + term.length));
        }

        const options = () => $panel.find('[role="option"]');

        function open() {
            $panel.prop('hidden', false);
            $input.attr('aria-expanded', 'true');
        }

        function close() {
            $panel.prop('hidden', true);
            $input.attr('aria-expanded', 'false').removeAttr('aria-activedescendant');
            setActive(-1);
        }

        function setActive(index) {
            const $opts = options();
            active = index;

            $opts.removeClass('is-active').attr('aria-selected', 'false');

            if (index >= 0 && $opts.length) {
                const $current = $opts.eq(index).addClass('is-active').attr('aria-selected', 'true');
                $input.attr('aria-activedescendant', $current.attr('id'));
                $current[0].scrollIntoView({ block: 'nearest' });
            } else {
                $input.removeAttr('aria-activedescendant');
            }
        }

        function render(res, term) {
            const products   = res.products || [];
            const categories = res.categories || [];
            let n = 0;
            let html = '';

            if (!products.length && !categories.length) {
                html = `<div class="sp-empty">محصولی برای «${esc(term)}» پیدا نشد.</div>`;
            } else {
                if (categories.length) {
                    html += '<div class="sp-cats">'
                        + categories.map((c) =>
                            `<a class="sp-cat" role="option" id="sp-opt-${n++}" href="${esc(c.url)}">${mark(c.name, term)}</a>`
                        ).join('')
                        + '</div>';
                }

                html += products.map((p) => `
                    <a class="sp-item" role="option" id="sp-opt-${n++}" href="${esc(p.url)}">
                        <img src="${esc(p.image || '')}" alt="" width="44" height="44" loading="lazy">
                        <span class="sp-name">${mark(p.name, term)}</span>
                        <span class="sp-price">
                            ${p.old_price ? `<s>${fa(p.old_price)}</s>` : ''}
                            <b>${fa(p.price)}</b> تومان
                        </span>
                    </a>`).join('');

                if (res.all_url) {
                    html += `<a class="sp-all" role="option" id="sp-opt-${n++}" href="${esc(res.all_url)}">مشاهده همه نتایج «${esc(term)}»</a>`;
                }
            }

            $panel.html(html);
            setActive(-1);
            open();
        }

        function search(term) {
            if (cache.has(term)) {
                render(cache.get(term), term);
                return;
            }

            if (request) request.abort();

            $box.addClass('is-loading');

            request = Ajax.get(url, { q: term })
                .done(function (res) {
                    cache.set(term, res);

                    // کاربر در این فاصله چیز دیگری تایپ کرده؟ پاسخ کهنه را نشان نده
                    if ($input.val().trim() === term) render(res, term);
                })
                .fail(function (xhr, textStatus) {
                    if (textStatus !== 'abort') close();
                })
                .always(function () {
                    $box.removeClass('is-loading');
                });
        }

        // تایپ
        $input.on('input', function () {
            clearTimeout(timer);
            const term = $input.val().trim();

            if (term.length < MIN_CHARS) {
                if (request) request.abort();
                $box.removeClass('is-loading');
                close();
                return;
            }

            timer = setTimeout(() => search(term), DELAY);
        });

        // فوکوس: اگر نتیجه‌ای از قبل داریم دوباره نشان بده
        $input.on('focus', function () {
            if ($panel.children().length && $input.val().trim().length >= MIN_CHARS) open();
        });

        // کیبورد
        $input.on('keydown', function (e) {
            const $opts = options();

            switch (e.key) {
                case 'ArrowDown':
                    if ($panel.prop('hidden') || !$opts.length) return;
                    e.preventDefault();
                    setActive((active + 1) % $opts.length);
                    break;

                case 'ArrowUp':
                    if ($panel.prop('hidden') || !$opts.length) return;
                    e.preventDefault();
                    setActive(active <= 0 ? $opts.length - 1 : active - 1);
                    break;

                case 'Enter':
                    if (active >= 0 && !$panel.prop('hidden')) {
                        e.preventDefault();
                        window.location.href = $opts.eq(active).attr('href');
                    }
                    // وگرنه فرم عادی ارسال می‌شود
                    break;

                case 'Escape':
                    close();
                    break;
            }
        });

        // کلیک بیرون از کادر
        $(document).on('click', function (e) {
            if (!$(e.target).closest($box).length) close();
        });

        // میانبر «/» برای رفتن به جستجو
        $(document).on('keydown', function (e) {
            const tag = (e.target.tagName || '').toLowerCase();
            if (e.key === '/' && !['input', 'textarea', 'select'].includes(tag) && !e.target.isContentEditable) {
                e.preventDefault();
                $input.trigger('focus');
            }
        });
    });
})();
