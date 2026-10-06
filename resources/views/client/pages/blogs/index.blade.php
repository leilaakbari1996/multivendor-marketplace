@extends('client.layouts.app')

@section('title', 'وبلاگ')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('client/custom/css/recent-post.css') }}">

    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/forms.css') }}"
    >
@endpush

@section('content')

    <section class="blog-page py-5">

        <div class="container-fluid">

            <div class="row g-4"
                 data-filter-container
                 data-grid="#blogGrid"
                 data-pagination="#blogPaginationWrapper"
                 data-count="#postsCount"
                 data-sort="#sortForm"
                 data-count-label="مطلب"
            >

                @include('client.partials.blog.filter-sidebar')

                <div class="col-lg-9">

                    <div class="products-header mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <span class="fw-semibold" id="postsCount">
                                {{ $posts->total() }} مطلب
                            </span>
                        </div>
                    </div>

                    <div id="blogGrid" class="row g-4">
                        @include('client.partials.blog.grid')
                    </div>

                    <div id="blogPaginationWrapper" class="mt-5 d-flex justify-content-center">
                        @if($posts->hasPages())
                            <x-client.pagination :paginator="$posts->withQueryString()" />
                        @endif
                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('admin/custom/js/ajax.js') }}"></script>
    <script src="{{ asset('client/custom/js/filters.js') }}"></script>
    <script src="{{ asset('client/custom/js/likes.js') }}"></script>
@endpush
