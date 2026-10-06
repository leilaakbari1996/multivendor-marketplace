document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('favoritesGrid');
    if (!grid) return;

    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    grid.addEventListener('click', async (e) => {
        const btn = e.target.closest('.favorite-remove');
        if (!btn) return;

        btn.disabled = true;

        try {
            const res = await fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) throw new Error();

            btn.closest('[data-favorite-item]').remove();
            updateState();
        } catch {
            btn.disabled = false;
            alert('خطا در انجام عملیات. لطفاً دوباره تلاش کنید.');
        }
    });

    function updateState() {
        const remaining = grid.querySelectorAll('[data-favorite-item]').length;
        const counter = document.getElementById('favoritesCount');
        if (counter) counter.textContent = `${remaining} محصول در این صفحه`;

        if (remaining === 0) window.location.reload();
    }
});
