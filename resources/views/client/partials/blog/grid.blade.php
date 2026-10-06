@forelse($posts as $post)

    <div class="col-md-4">
        <x-client.blog-card :post="$post" />
    </div>

@empty

    <div class="col-12">
        <div class="empty-state text-center py-5 px-3 mx-auto">

            <div class="empty-state-icon mx-auto mb-4">
                <i class="bi bi-journal-text"></i>
            </div>

            <h5 class="fw-bold mb-2">مطلبی یافت نشد</h5>
            <p class="text-muted mb-4">
                مطلبی مطابق با جستجوی شما پیدا نشد.<br>
                می‌تونی عبارت جستجو یا دسته‌بندی رو تغییر بدی.
            </p>

            @if(request()->hasAny(['search']))
                <a href="{{ url()->current() }}" class="btn btn-outline-brand rounded-3 clear-filters-link">
                    <i class="bi bi-x-lg me-1"></i>
                    حذف فیلترها
                </a>
            @endif

        </div>
    </div>

@endforelse


