{{-- Filters --}}
<aside class="col-lg-3">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden filter-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="fw-bold mb-1">فیلتر محصولات</h5>
                    <small class="text-muted">محصولات موردنظر خود را پیدا کنید</small>
                </div>

                <span class="filter-icon-badge">
                    <i class="bi bi-sliders fs-5"></i>
                </span>
            </div>

            @php
                $hasFilters = request()->hasAny([
                    'search', 'category', 'min_price', 'max_price', 'in_stock', 'on_sale',
                ]);
            @endphp

            @if($hasFilters)
                <div class="active-filter-pill mb-4">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    فیلتر فعال است
                </div>
            @endif

            <form id="filterForm" action="{{ url()->current() }}" method="GET"
                  id="filterForm"
                  data-filter-form>

                <x-client.forms.input
                    name="search"
                    label="جستجو"
                    icon="search"
                    placeholder="نام محصول را وارد کنید..."
                    value="{{ request('search') }}"
                />

                <hr class="my-4">

                <x-client.forms.select
                    name="category"
                    label="دسته‌بندی"
                    placeholder="همه دسته‌بندی‌ها"
                    :options="$categories->pluck('name','slug')"
                    :selected="request('category')"
                />

                <hr class="my-4">

                <x-client.forms.price-range />

                <hr class="my-4">

                <div class="mb-4 d-flex flex-column gap-3">

                    <x-client.forms.switch
                        name="is_best_selling"
                        label="محصولات پرفروش"
                        icon="trophy"
                        :checked="request()->boolean('is_best_selling')"
                    />

                    <x-client.forms.switch
                        name="is_featured"
                        label="محصولات ویژه"
                        icon="box-seam"
                        :checked="request()->boolean('is_featured')"
                    />

                    <x-client.forms.switch
                        name="in_stock"
                        label="محصولات موجود"
                        icon="box-seam"
                        :checked="request()->boolean('in_stock')"
                    />

                    <x-client.forms.switch
                        name="on_sale"
                        label="محصولات تخفیف‌دار"
                        icon="tag"
                        :checked="request()->boolean('on_sale')"
                    />
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                    <x-client.forms.search-button
                        class="w-100"
                    />

                </div>

            </form>

        </div>
    </div>

</aside>
