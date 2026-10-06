@forelse($products as $product)

    <div class="col">
        <x-client.product-card :product="$product" />
    </div>

@empty

    <div class="col-12" style="width: 100%">
        <div class="empty-state text-center py-5">
            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
            <p class="mb-3 text-muted">
                محصولی مطابق با فیلترهای انتخاب‌شده پیدا نشد.
            </p>

            @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'in_stock', 'on_sale']))
                <a href="{{ url()->current() }}" class="btn btn-light border rounded-3 clear-filters-link">
                    <i class="bi bi-x-lg me-1"></i>
                    حذف فیلترها
                </a>
            @endif
        </div>
    </div>

@endforelse
