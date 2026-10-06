/**
 * =============================================================
 * AJAX Utility
 * =============================================================
 * مسئولیت:
 * - ارسال درخواست‌های AJAX
 * - تنظیم CSRF Token
 * - دریافت JSON
 * - پشتیبانی از GET / POST / PUT / PATCH / DELETE
 *
 * این فایل هیچ وابستگی به:
 * - SweetAlert
 * - Toast
 * - DataTable
 * - Form
 * ندارد.
 *
 * استفاده:
 *
 * Ajax.get(url)
 * Ajax.post(url, data)
 * Ajax.put(url, data)
 * Ajax.patch(url, data)
 * Ajax.delete(url)
 * =============================================================
 */

const Ajax = {

    /**
     * ارسال درخواست عمومی
     */
    request(url, method = 'GET', data = {}, options = {}) {
        return $.ajax({
            url: url,
            type: method,
            data: data,

            headers: {
                'X-CSRF-TOKEN': this.getCsrfToken(),
                'Accept': 'application/json',
                ...(options.headers || {}),
            },

            ...options,
        });
    },

    /**
     * دریافت CSRF Token
     */
    getCsrfToken() {
        return $('meta[name="csrf-token"]').attr('content');
    },

    /**
     * GET
     */
    get(url, data = {}, options = {}) {
        return this.request(
            url,
            'GET',
            data,
            options
        );
    },

    /**
     * POST
     */
    post(url, data = {}, options = {}) {
        return this.request(
            url,
            'POST',
            data,
            options
        );
    },

    /**
     * PUT
     */
    put(url, data = {}, options = {}) {
        return this.request(
            url,
            'PUT',
            data,
            options
        );
    },

    /**
     * PATCH
     */
    patch(url, data = {}, options = {}) {
        return this.request(
            url,
            'PATCH',
            data,
            options
        );
    },

    /**
     * DELETE
     */
    delete(url, data = {}, options = {}) {
        return this.request(
            url,
            'DELETE',
            data,
            options
        );
    },
};

window.Ajax = Ajax;
