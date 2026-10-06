
<aside class="col-lg-3">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden filter-card">

        <div class="card-body p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="fw-bold mb-1">جستجو در وبلاگ</h5>
                    <small class="text-muted">مطلب موردنظر خود را پیدا کنید</small>
                </div>

                <span class="filter-icon-badge">
                    <i class="bi bi-sliders fs-5"></i>
                </span>
            </div>

            @php
                $hasFilters = request()->hasAny(['search']);
            @endphp

            @if($hasFilters)
                <div class="active-filter-pill mb-4">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    فیلتر فعال است
                </div>
            @endif

            <form action="{{ url()->current() }}" method="GET"
                  id="filterForm" data-filter-form>

                <x-client.forms.input
                    name="search"
                    label="جستجو"
                    icon="search"
                    placeholder="عنوان مطلب را وارد کنید..."
                    value="{{ request('search') }}"
                />

                <hr class="my-4">


                {{-- Actions --}}
                <div class="d-grid gap-2 mt-4">
                    <x-client.forms.search-button
                        class="w-100"
                    />
                </div>

            </form>

        </div>
    </div>

    @include('client.partials.blog.recent-posts')

</aside>

