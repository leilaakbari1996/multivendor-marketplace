/**
 * =============================================================
 * Profile Addresses
 * =============================================================
 * وابستگی‌ها: jQuery, Bootstrap 5 (bundle), window.Ajax
 *
 * window.addressConfig = {
 *     addresses: [...],   // هر آدرس باید province_id, county_id, sector_id, city_id
 *                         // و نام‌های province, county, sector, city را داشته باشد
 *     routes: {
 *         store, update, destroy, def,      // update/destroy/def شامل :id
 *         provinces,                        // GET /provinces
 *         counties,                         // GET /provinces/:id/counties
 *         sectors,                          // GET /counties/:id/sectors
 *         cities                            // GET /sectors/:id/cities
 *     }
 * };
 * =============================================================
 */

$(function () {
    'use strict';

    const config = window.addressConfig || {};
    const routes = config.routes || {};

    let addresses = config.addresses || [];

    const url = (key, id) => routes[key].replace(':id', id);

    const modalEl = document.getElementById('adModal');
    const modal = new bootstrap.Modal(modalEl);

    // اگر مودال حذف در صفحه نباشد، اسکریپت نباید از کار بیفتد
    const delEl = document.getElementById('adDel');
    const delModal = delEl ? new bootstrap.Modal(delEl) : null;

    const $form = $('#adForm');

    let delId = null;
    let busy = false;


    /* ---------------------------------------------------------
     * Helpers
     * --------------------------------------------------------- */

    const ESC_MAP = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    };

    const esc = (value) =>
        String(value == null ? '' : value)
            .replace(/[&<>"']/g, (c) => ESC_MAP[c]);

    /** تبدیل ارقام فارسی و عربی به انگلیسی */
    const fa2en = (value) =>
        String(value == null ? '' : value)
            .replace(/[۰-۹]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d))
            .replace(/[٠-٩]/g, (d) => '٠١٢٣٤٥٦٧٨٩'.indexOf(d));

    const opt = (value, text) =>
        '<option value="' + esc(value) + '">' + esc(text) + '</option>';

    function sync(response) {

        addresses = (response && response.addresses) || [];

        render();

        if (response && response.message) {
            toast.success(response.message);
        }
    }

    function fail(xhr) {

        toast.error(
            (xhr && xhr.responseJSON && xhr.responseJSON.message)
            || 'خطایی رخ داد. دوباره تلاش کنید.'
        );
    }

    function setBusy(state) {

        busy = state;

        $('#adSave')
            .prop('disabled', state)
            .text(state ? 'در حال ذخیره...' : 'ذخیره آدرس');
    }


    /* ---------------------------------------------------------
     * Render Addresses
     * --------------------------------------------------------- */

    function render() {

        $('#adCount').text(
            addresses.length ? addresses.length + ' آدرس' : ''
        );

        if (!addresses.length) {

            $('#adList').html(
                '<div class="ad-empty">' +
                '<i class="bi bi-geo-alt"></i>' +
                '<p>هنوز آدرسی ثبت نکرده‌اید. ' +
                'برای سفارش سریع‌تر، اولین آدرس خود را اضافه کنید.</p>' +
                '<button type="button" class="ad-btn mx-auto" id="adFirst">' +
                '<i class="bi bi-plus-lg"></i> افزودن آدرس' +
                '</button>' +
                '</div>'
            );

            return;
        }

        const list = addresses
            .slice()
            .sort((a, b) => (+b.is_default) - (+a.is_default));

        const cards = list.map((a) => {

            const full = [
                a.province,
                a.county,
                a.sector,
                a.city,
                a.address,
                a.plaque ? 'پلاک ' + a.plaque : '',
                a.unit ? 'واحد ' + a.unit : ''
            ]
                .filter(Boolean)
                .map(esc)
                .join('، ');

            return (
                '<div class="ad-item' + (a.is_default ? ' def' : '') +
                '" data-id="' + esc(a.id) + '">' +

                '<div class="ad-top">' +
                '<b><i class="bi bi-geo-alt-fill"></i>' + esc(a.title) + '</b>' +
                (a.is_default ? '<span class="ad-tag">پیش‌فرض</span>' : '') +
                '</div>' +

                '<p class="ad-text">' + full + '</p>' +

                '<div class="ad-meta">' +
                '<span><i class="bi bi-person"></i>' + esc(a.recipient_name) + '</span>' +
                '<span><i class="bi bi-telephone"></i>' + esc(a.recipient_mobile) + '</span>' +
                '<span><i class="bi bi-mailbox"></i>' + esc(a.postal_code) + '</span>' +
                '</div>' +

                '<div class="ad-act">' +
                '<button type="button" class="edit"><i class="bi bi-pencil"></i> ویرایش</button>' +
                '<button type="button" class="del"><i class="bi bi-trash3"></i> حذف</button>' +
                (a.is_default
                    ? ''
                    : '<button type="button" class="mk"><i class="bi bi-check2-circle"></i> پیش‌فرض شود</button>') +
                '</div>' +

                '</div>'
            );
        }).join('');

        $('#adList').html(
            '<div class="ad-grid">' +
            cards +
            '<button type="button" class="ad-add" id="adGrid">' +
            '<i class="bi bi-plus-circle"></i> افزودن آدرس جدید' +
            '</button>' +
            '</div>'
        );
    }


    /* ---------------------------------------------------------
     * Cascading Selects (Province → County → Sector → City)
     * ---------------------------------------------------------
     * هر سطح token مخصوص خودش را دارد؛ اگر کاربر وسط بارگذاری
     * گزینه‌ی بالاتر را عوض کند، پاسخ قدیمی نادیده گرفته می‌شود.
     */

    const levels = [
        { sel: '#f-province', route: null,       prop: 'provinces', plural: 'استان‌ها',    hint: '' },
        { sel: '#f-county',   route: 'counties', prop: 'counties',  plural: 'شهرستان‌ها', hint: 'ابتدا استان را انتخاب کنید' },
        { sel: '#f-sector',   route: 'sectors',  prop: 'sectors',   plural: 'بخش‌ها',     hint: 'ابتدا شهرستان را انتخاب کنید' },
        { sel: '#f-city',     route: 'cities',   prop: 'cities',    plural: 'شهرها',      hint: 'ابتدا بخش را انتخاب کنید' }
    ];

    const tokens = [0, 0, 0, 0];
    const pending = [null, null, null, null];


    /* ---------------------------------------------------------
     * Select2
     * ---------------------------------------------------------
     * اگر select2 لود نشده باشد، فرم با select معمولی کار می‌کند.
     */

    const useS2 = !!($.fn && $.fn.select2);

    /** بعد از تغییر برنامه‌ای option یا value، نمایش Select2 را به‌روز می‌کند
     *  (change.select2 هندلرهای change خودمان را اجرا نمی‌کند) */
    const refresh = ($el) => {
        if (useS2) {
            $el.trigger('change.select2');
        }
    };

    /** نرمال‌سازی برای جستجو: ی/ک عربی، نیم‌فاصله، حروف بزرگ و کوچک */
    const norm = (s) =>
        fa2en(s)
            .replace(/ي/g, 'ی')
            .replace(/ك/g, 'ک')
            .replace(/[\u200c\u200f\s]+/g, '')
            .toLowerCase();

    if (useS2) {

        $(levels.map((lv) => lv.sel).join(',')).select2({
            theme: 'bootstrap-5',
            dir: 'rtl',
            width: '100%',
            dropdownParent: $(modalEl),
            language: {
                noResults: () => 'موردی یافت نشد',
                searching: () => 'در حال جستجو...'
            },
            matcher: function (params, data) {

                if ($.trim(params.term) === '') {
                    return data;
                }

                if (typeof data.text === 'undefined') {
                    return null;
                }

                return norm(data.text).indexOf(norm(params.term)) > -1
                    ? data
                    : null;
            }
        });
    }

    /** فوکوس روی اولین فیلد نامعتبر (برای Select2 روی خود کادر) */
    function focusFirstInvalid() {

        const $field = $form.find('.is-invalid').first();

        if (!$field.length) {
            return;
        }

        if (useS2 && $field.is('select')) {

            $field
                .next('.select2-container')
                .find('.select2-selection')
                .trigger('focus');

        } else {

            $field.trigger('focus');
        }
    }

    function cancel(i) {

        tokens[i]++;

        if (pending[i] && typeof pending[i].abort === 'function') {
            pending[i].abort();
        }

        pending[i] = null;
    }

    function emptyLevel(i) {

        cancel(i);

        const $el = $(levels[i].sel);

        $el
            .html(opt('', levels[i].hint))
            .val('')
            .prop('disabled', true);

        refresh($el);
    }

    function resetFrom(i) {

        for (let j = i; j < levels.length; j++) {
            emptyLevel(j);
        }
    }

    function pick(response, key) {

        if (Array.isArray(response)) {
            return response;
        }

        const list = response && (response[key] || response.data);

        return Array.isArray(list) ? list : [];
    }

    /**
     * @param {number} i         اندیس سطح (0 = استان)
     * @param {*}      parentId  شناسه‌ی والد (برای استان لازم نیست)
     * @param {Array}  chosen    شناسه‌های انتخاب‌شده برای این سطح و سطوح پایین‌تر
     */
    function loadLevel(i, parentId, chosen) {

        chosen = chosen || [];

        resetFrom(i + 1);

        const lv = levels[i];
        const $el = $(lv.sel);

        if (i > 0 && !parentId) {
            emptyLevel(i);
            return;
        }

        cancel(i);

        const token = tokens[i];

        $el
            .html(opt('', 'در حال دریافت ' + lv.plural + '...'))
            .val('')
            .prop('disabled', true);

        refresh($el);

        const req = Ajax.get(
            i === 0 ? routes.provinces : url(lv.route, parentId)
        );

        pending[i] = req;

        req
            .done(function (response) {

                if (token !== tokens[i]) {
                    return;
                }

                const items = pick(response, lv.prop);

                $el
                    .html(
                        opt('', 'انتخاب کنید') +
                        items.map((it) => opt(it.id, it.name)).join('')
                    )
                    .val('')
                    .prop('disabled', false);

                refresh($el);

                const wanted = chosen[0];

                if (
                    wanted &&
                    items.some((it) => String(it.id) === String(wanted))
                ) {

                    $el.val(String(wanted));

                    refresh($el);

                    if (i < levels.length - 1) {
                        loadLevel(i + 1, wanted, chosen.slice(1));
                    }
                }
            })

            .fail(function (xhr) {

                if (token !== tokens[i]) {
                    return;
                }

                $el
                    .html(opt('', 'خطا در دریافت ' + lv.plural))
                    .val('')
                    .prop('disabled', true);

                refresh($el);

                fail(xhr);
            });
    }

    $('#f-province').on('change', function () { loadLevel(1, this.value); });
    $('#f-county').on('change', function () { loadLevel(2, this.value); });
    $('#f-sector').on('change', function () { loadLevel(3, this.value); });

    // اگر مودال بسته شد، درخواست‌های در حال انجام بی‌اثر شوند
    modalEl.addEventListener('hidden.bs.modal', function () {
        levels.forEach((_, i) => cancel(i));
    });


    /* ---------------------------------------------------------
     * Form
     * --------------------------------------------------------- */

    const textFields = [
        'title',
        'recipient_name',
        'recipient_mobile',
        'postal_code',
        'address',
        'plaque',
        'unit'
    ];

    // متن پیش‌فرض پیام‌های خطا را نگه می‌داریم تا پیام سرور آن را برای همیشه عوض نکند
    $form.find('.invalid-feedback').each(function () {
        $(this).data('default', $.trim($(this).text()));
    });

    function clearErrors() {

        $form.find('.is-invalid').removeClass('is-invalid');

        $form.find('.invalid-feedback').each(function () {
            $(this).text($(this).data('default'));
        });
    }

    function openForm(address) {

        address = address || {};

        $form[0].reset();

        clearErrors();
        setBusy(false);

        $form.find('[name=id]').val(address.id || '');

        textFields.forEach((field) => {
            $form
                .find('[name=' + field + ']')
                .val(address[field] == null ? '' : address[field]);
        });

        $('#f-def').prop('checked', !!address.is_default);

        // در حالت ویرایش، چهار سطح به‌صورت زنجیره‌ای انتخاب می‌شوند
        loadLevel(0, null, [
            address.province_id || '',
            address.county_id || '',
            address.sector_id || '',
            address.city_id || ''
        ]);

        $('#adModalTitle').text(address.id ? 'ویرایش آدرس' : 'آدرس جدید');

        modal.show();
    }

    $(document).on('click', '#adNew, #adFirst, #adGrid', function () {
        openForm();
    });

    $(document).on('click', '.ad-item .edit', function () {

        const id = $(this).closest('.ad-item').data('id');

        const address = addresses.find((a) => a.id == id);

        if (address) {
            openForm(address);
        }
    });

    $('#f-phone, #f-postal, #f-plaque').on('input', function () {
        this.value = fa2en(this.value).replace(/\D/g, '');
    });

    $form.on('input change', '.is-invalid', function () {
        $(this).removeClass('is-invalid');
    });


    /* ---------------------------------------------------------
     * Save
     * --------------------------------------------------------- */

    // serializeArray فیلدهای disabled را نمی‌خواند، پس مستقیم از فیلد می‌خوانیم
    const raw = (name) =>
        $.trim($form.find('[name="' + name + '"]').val() || '');

    $form.on('submit', function (e) {

        e.preventDefault();

        if (busy) {
            return;
        }

        clearErrors();

        const data = {
            id: raw('id'),
            title: raw('title'),
            recipient_name: raw('recipient_name'),
            recipient_mobile: fa2en(raw('recipient_mobile')),
            province_id: raw('province_id'),
            county_id: raw('county_id'),
            sector_id: raw('sector_id'),
            city_id: raw('city_id'),
            address: raw('address'),
            postal_code: fa2en(raw('postal_code')),
            plaque: fa2en(raw('plaque')),
            unit: raw('unit')
        };

        const plaqueOk =
            !data.plaque ||
            (
                /^\d{1,5}$/.test(data.plaque) &&
                +data.plaque >= 1 &&
                +data.plaque <= 65535
            );

        const rules = {
            title: data.title.length >= 2 && data.title.length <= 30,
            recipient_name: data.recipient_name.length >= 3,
            recipient_mobile: /^09\d{9}$/.test(data.recipient_mobile),
            province_id: !!data.province_id,
            county_id: !!data.county_id,
            sector_id: !!data.sector_id,
            city_id: !!data.city_id,
            address: data.address.length >= 10,
            postal_code: /^\d{10}$/.test(data.postal_code),
            plaque: plaqueOk,
            unit: data.unit.length <= 10
        };

        let valid = true;

        $.each(rules, function (field, ok) {

            $form
                .find('[name="' + field + '"]')
                .toggleClass('is-invalid', !ok);

            if (!ok) {
                valid = false;
            }
        });

        if (!valid) {

            focusFirstInvalid();

            return;
        }

        const id = data.id;

        delete data.id;

        data.is_default = $('#f-def').is(':checked') ? 1 : 0;

        setBusy(true);

        const request = id
            ? Ajax.put(url('update', id), data)
            : Ajax.post(routes.store, data);

        request

            .done(function (response) {
                sync(response);

                modal.hide();
            })

            .fail(function (xhr) {

                const errors = xhr.responseJSON && xhr.responseJSON.errors;

                if (xhr.status === 422 && errors) {

                    let shown = false;
                    toast.error(response.message || 'اطلاعات واردشده معتبر نیست.');

                    $.each(errors, function (field, messages) {

                        const $field = $form.find('[name="' + field + '"]');

                        if ($field.length) {

                            $field
                                .addClass('is-invalid')
                                .siblings('.invalid-feedback')
                                .text(messages[0]);

                            shown = true;
                        }
                    });

                    if (shown) {
                        focusFirstInvalid();
                    } else {
                        fail(xhr);
                    }

                } else {

                    fail(xhr);
                }
            })

            .always(function () {

                setBusy(false);
            });
    });


    /* ---------------------------------------------------------
     * Make Default
     * --------------------------------------------------------- */

    $(document).on('click', '.ad-item .mk', function () {

        if (busy) {
            return;
        }

        busy = true;

        const id = $(this).closest('.ad-item').data('id');

        Ajax.patch(url('def', id))
            .done(function (response) {

                sync(response);

            })
            .fail(fail)
            .always(function () { busy = false; });
    });


    /* ---------------------------------------------------------
     * Delete
     * --------------------------------------------------------- */

    function destroy() {

        if (busy || !delId) {
            return;
        }

        busy = true;

        Ajax.delete(url('destroy', delId))

            .done(function (response) {

                sync(response);

                if (delModal) {
                    delModal.hide();
                }
            })

            .fail(fail)

            .always(function () { busy = false; });
    }

    $(document).on('click', '.ad-item .del', function (e) {
        e.preventDefault();

        const button = $(this);
        const id = button.closest('.ad-item').data('id');

        if (!id) {
            console.error('Address ID is missing.');
            return;
        }

        const url = addressConfig.routes.destroy.replace(':id', id);

        confirmDelete().then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            Ajax.delete(url)
                .done(function (response) {

                    sync(response);
                })
                .fail(function (xhr) {
                    toast.error(
                        xhr.responseJSON?.message ?? 'حذف آدرس انجام نشد.'
                    );
                });
        });
    });

    $('#adDelOk').on('click', destroy);


    /* ---------------------------------------------------------
     * Initial Render
     * --------------------------------------------------------- */

    render();

});
