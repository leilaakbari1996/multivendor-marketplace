@extends('client.layouts.app')

@section('title', 'محصولات')

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/product-show.css') }}"
    >
@endpush

@section('content')

    <section class="products-page">

        <div class="container-fluid">

            <div class="row g-4"
                 data-filter-container
                 data-grid="#productsGrid"
                 data-pagination="#paginationWrapper"
                 data-count="#productsCount"
                 data-sort="#sortForm"
                 data-count-label="محصول"
            >

                @include('client.partials.product.filter-sidebar')

                {{-- Products --}}
                <div class="col-lg-9">

                    {{-- Products Header --}}
                    <div class="products-header mb-4">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <div>
                                <span class="fw-semibold" id="productsCount">
                                    {{ $products->total() }} محصول
                                </span>
                            </div>

                            {{-- Sort --}}
                            <form id="sortForm" action="{{ url()->current() }}" method="GET" class="sort-form">

                                @foreach(request()->except('sort', 'page') as $key => $value)
                                    @if(is_array($value))
                                        @foreach($value as $item)
                                            <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach

                                <select
                                    name="sort"
                                    class="form-select rounded-3"
                                    aria-label="مرتب‌سازی محصولات"
                                >
                                    <option value="">مرتب‌سازی</option>
                                    <option value="latest" @selected(request('sort') === 'latest')>جدیدترین</option>
                                    <option value="price_asc" @selected(request('sort') === 'price_asc')>ارزان‌ترین</option>
                                    <option value="price_desc" @selected(request('sort') === 'price_desc')>گران‌ترین</option>
                                </select>

                            </form>

                        </div>

                    </div>

                    {{-- Product List --}}
                    <div id="productsGrid" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                        @include('client.partials.product.grid')
                    </div>

                    {{-- Pagination --}}
                    <div id="paginationWrapper" class="mt-5 d-flex justify-content-center">
                        @if($products->hasPages())
                            <x-client.pagination :paginator="$products->withQueryString()" />
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/filters.js') }}"></script>
@endpush


