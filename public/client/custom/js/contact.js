
    // شمارنده کاراکتر پیام (با ارقام فارسی)
    (function () {
    const area = document.getElementById('c-message');
    const out  = document.getElementById('msg-counter');
    if (!area || !out) return;
    const fa = (n) => Number(n).toLocaleString('fa-IR', { useGrouping: false });
    const update = () => out.textContent = fa(area.value.length) + ' / ' + fa(area.maxLength);
    area.addEventListener('input', update);
    update();
})();



    (function () {
    const form = document.getElementById('contact-form');
    if (!form) return;

    const btn     = form.querySelector('[type="submit"]');
    const btnText = btn.innerHTML;
    const alertId = 'contact-alert';

    function clearErrors() {
    hideAlert(alertId);
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.js-error').forEach(el => el.remove());
}

    function showFieldErrors(errors) {
    Object.entries(errors).forEach(([name, messages]) => {
    const field = form.querySelector('[name="' + name + '"]');
    if (!field) return;
    field.classList.add('is-invalid');

    const div = document.createElement('div');
    div.className = 'invalid-feedback d-block js-error';
    div.textContent = messages[0];
    field.insertAdjacentElement('afterend', div);
});
}

    form.addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors();

    btn.disabled = true;
    btn.innerHTML = 'در حال ارسال...';

    Ajax.post(form.action, new FormData(form), {
    processData: false,
    contentType: false,
})
    .done(function (data) {
    showAlert(alertId, 'success', data.message || 'پیام شما ارسال شد.');
    form.reset();
    form.querySelector('#c-message')?.dispatchEvent(new Event('input'));
})
    .fail(function (xhr) {
    const data = xhr.responseJSON || {};

    switch (xhr.status) {
    case 422:
    showFieldErrors(data.errors || {});
    showAlert(alertId, 'danger', 'لطفاً خطاهای فرم را بررسی کنید.');
    break;
    case 419:
    showAlert(alertId, 'warning', 'نشست شما منقضی شده؛ صفحه را یک بار رفرش کنید.');
    break;
    case 429:
    showAlert(alertId, 'warning', 'تعداد درخواست‌ها زیاد است؛ کمی بعد دوباره تلاش کنید.');
    break;
    default:
    showAlert(alertId, 'danger', data.message || 'خطایی رخ داد؛ دوباره تلاش کنید.');
}
})
    .always(function () {
    btn.disabled = false;
    btn.innerHTML = btnText;
});
});
})();
