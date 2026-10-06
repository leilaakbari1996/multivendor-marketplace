(function () {
    'use strict';

    const container = document.querySelector('[data-filter-container]');

    if (!container) {
        return;
    }

    const filterForm = container.querySelector('[data-filter-form]');
    const sortForm = document.querySelector(
        container.dataset.sort
    );
    const gridWrapper = document.querySelector(
        container.dataset.grid
    );
    const paginationWrapper = document.querySelector(
        container.dataset.pagination
    );
    const countEl = document.querySelector(
        container.dataset.count
    );

    if (!filterForm || !gridWrapper) {
        return;
    }

    function setLoading(isLoading) {
        gridWrapper.classList.toggle(
            'is-loading',
            isLoading
        );

        document
            .querySelectorAll('[data-submit-btn]')
            .forEach((button) => {
                button.disabled = isLoading;
            });
    }

    function buildParamsFromForm() {
        const params = new URLSearchParams(
            new FormData(filterForm)
        );

        for (const key of [...params.keys()]) {
            if (params.get(key) === '') {
                params.delete(key);
            }
        }

        const sortValue = sortForm
            ?.querySelector('[name="sort"]')
            ?.value;

        if (sortValue) {
            params.set('sort', sortValue);
        }

        return Object.fromEntries(params.entries());
    }

    function fetchProducts(
        params = {},
        {
            pushToHistory = true,
            scroll = true,
        } = {}
    ) {
        const queryString = new URLSearchParams(params).toString();

        const url = queryString
            ? `${window.location.pathname}?${queryString}`
            : window.location.pathname;

        setLoading(true);

        Ajax.get(url)
            .done(function (data) {
                gridWrapper.innerHTML = data.grid_html;

                if (paginationWrapper) {
                    paginationWrapper.innerHTML =
                        data.pagination_html;
                }

                if (countEl) {
                    const label =
                        container.dataset.countLabel || '';

                    countEl.textContent =
                        `${data.total} ${label}`.trim();
                }

                if (pushToHistory) {
                    window.history.pushState({}, '', url);
                }

                if (scroll) {
                    gridWrapper.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                }
            })
            .fail(function (xhr) {
                console.error(
                    'خطا در بارگذاری محصولات:',
                    xhr
                );
            })
            .always(function () {
                setLoading(false);
            });
    }

    // Filter
    filterForm.addEventListener(
        'submit',
        function (event) {
            event.preventDefault();

            fetchProducts(
                buildParamsFromForm()
            );
        }
    );

    // Sort
    sortForm?.addEventListener(
        'change',
        function (event) {
            if (event.target.name !== 'sort') {
                return;
            }

            fetchProducts(
                buildParamsFromForm()
            );
        }
    );

    // Clear filters
    document.addEventListener(
        'click',
        function (event) {
            const clearLink =
                event.target.closest(
                    '.clear-filters-link'
                );

            if (!clearLink) {
                return;
            }

            event.preventDefault();

            filterForm.reset();

            fetchProducts();
        }
    );

    // Pagination
    document.addEventListener(
        'click',
        function (event) {
            const link = event.target.closest(
                `${container.dataset.pagination} a.page-link`
            );

            if (!link) {
                return;
            }

            event.preventDefault();

            const linkUrl = new URL(
                link.href,
                window.location.origin
            );

            fetchProducts(
                Object.fromEntries(
                    linkUrl.searchParams.entries()
                )
            );
        }
    );

    // Browser back / forward
    window.addEventListener(
        'popstate',
        function () {
            fetchProducts(
                Object.fromEntries(
                    new URLSearchParams(
                        window.location.search
                    ).entries()
                ),
                {
                    pushToHistory: false,
                    scroll: false,
                }
            );
        }
    );
})();
