/**
 * =============================================================
 *  Alert / Toast Utility (SweetAlert2 wrapper)
 * =============================================================
 * این فایل به‌صورت اسکریپت معمولی (بدون bundler) لود می‌شود،
 * پس همه‌چیز روی window قرار می‌گیرد و در کل پروژه در دسترس است.
 *
 * ترتیب لود در Blade باید این‌گونه باشد:
 *   1. sweetalert2.min.js   (کتابخانه اصلی)
 *   2. تگ LaravelFlash      (window.LaravelFlash = {...})
 *   3. این فایل (alert.js)
 *
 * استفاده در هر جای پروژه (بعد از لود این فایل):
 *   toast.success('با موفقیت ذخیره شد');
 *   toast.error('خطایی رخ داد');
 *
 *   confirmDelete().then((result) => {
 *       if (result.isConfirmed) { ... }
 *   });
 * =============================================================
 */

// -------------------------------------------------------------
// پیکربندی پایه‌ی Toast (گوشه‌ی صفحه، خودکار بسته می‌شود)
// -------------------------------------------------------------
const ToastBase = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toastEl) => {
        toastEl.addEventListener('mouseenter', Swal.stopTimer);
        toastEl.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

/**
 * توست‌های آماده برای هر نوع پیام
 */
const toast = {
    success(title, timer = 3000) {
        return ToastBase.fire({ icon: 'success', title, timer });
    },

    error(title, timer = 4000) {
        return ToastBase.fire({ icon: 'error', title, timer });
    },

    warning(title, timer = 3500) {
        return ToastBase.fire({ icon: 'warning', title, timer });
    },

    info(title, timer = 3000) {
        return ToastBase.fire({ icon: 'info', title, timer });
    },
};

// -------------------------------------------------------------
// مودال تاییدیه (برای عملیات حساس مثل حذف)
// -------------------------------------------------------------
/**
 * @param {string} message متن سوال تایید
 * @param {object} options امکان override تنظیمات پیش‌فرض
 * @returns {Promise<SweetAlertResult>}
 */
function confirmAction(message = 'مطمئن هستید؟', options = {}) {
    return Swal.fire({
        title: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، مطمئنم',
        cancelButtonText: 'انصراف',
        reverseButtons: true,
        focusCancel: true,
        ...options,
    });
}

/**
 * مودال تاییدیه‌ی مخصوص حذف (رنگ قرمز، متن آماده)
 */
function confirmDelete(message = ' ') {
    return Swal.fire({
        title: 'آیا برای حذف این آیتم مطمئن هستید؟',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'انصراف',
        confirmButtonColor: '#d33',
        reverseButtons: true,
        focusCancel: true,
    });
}

// -------------------------------------------------------------
// مودال کامل خطا (برای خطاهای مهم که نیاز به دیدن حتمی دارند)
// -------------------------------------------------------------
function alertError(title = 'خطا', text = '') {
    return Swal.fire({
        icon: 'error',
        title,
        text,
        confirmButtonText: 'باشه',
    });
}

// -------------------------------------------------------------
// اتصال خودکار به Session Flash Messages لاراول
// -------------------------------------------------------------
/**
 * این تابع را یک‌بار در فایل اصلی JS (مثلاً app.js یا bootstrap.js)
 * بعد از هر بار لود صفحه صدا بزنید تا پیام‌های session لاراول
 * به‌صورت خودکار به‌عنوان toast نمایش داده شوند.
 *
 * تگ window.LaravelFlash باید قبل از این فایل در Blade تعریف شده باشد
 * (همان‌طور که الان در layout پروژه هست).
 */
function handleLaravelFlash() {
    if (typeof window.LaravelFlash === 'undefined') return;

    const { success, error, warning, info } = window.LaravelFlash;

    if (success) toast.success(success);
    if (error) toast.error(error);
    if (warning) toast.warning(warning);
    if (info) toast.info(info);
}

// -------------------------------------------------------------
// در دسترس قرار دادن توابع در کل پروژه (روی window)
// -------------------------------------------------------------
window.toast = toast;
window.confirmAction = confirmAction;
window.confirmDelete = confirmDelete;
window.alertError = alertError;
window.handleLaravelFlash = handleLaravelFlash;

// -------------------------------------------------------------
// اجرای خودکار: به محض لود شدن این فایل، پیام‌های session لاراول
// (در صورت وجود) به‌صورت toast نمایش داده می‌شوند
// -------------------------------------------------------------
document.addEventListener('DOMContentLoaded', handleLaravelFlash);
