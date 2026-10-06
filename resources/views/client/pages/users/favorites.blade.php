@extends('client.pages.users.layout')

@section('profile-content')
    <div class="profile-card p-4" data-page="favorites">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0">محصولات مورد علاقه</h5>
            <small class="text-muted" id="productsFavoritesCount">
                {{ $products->total() }} محصول
            </small>
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-5 text-muted" id="productsFavoritesEmpty">
                <iconify-icon icon="uil:heart" width="48"></iconify-icon>
                <p class="mt-3 mb-0">
                    هنوز محصولی به علاقه‌مندی‌ها اضافه نکرده‌اید.
                </p>
            </div>
        @else
            <div class="row g-3" id="productsFavoritesGrid">
                @foreach ($products as $product)
                    <div
                        class="col-md-4"
                        data-favorite-item
                        data-like-card
                    >
                        <x-client.product-card :product="$product"/>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </div>

    <div class="profile-card p-4 mt-4" data-page="favorites">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0">وبلاگ‌های مورد علاقه</h5>
            <small class="text-muted" id="postsFavoritesCount">
                {{ $posts->total() }} وبلاگ
            </small>
        </div>

        @if ($posts->isEmpty())
            <div class="text-center py-5 text-muted" id="postsFavoritesEmpty">
                <iconify-icon icon="uil:heart" width="48"></iconify-icon>
                <p class="mt-3 mb-0">
                    هنوز وبلاگی به علاقه‌مندی‌ها اضافه نکرده‌اید.
                </p>
            </div>
        @else
            <div class="row g-3" id="postsFavoritesGrid">
                @foreach ($posts as $post)
                    <div
                        class="col-md-4"
                        data-favorite-item
                        data-like-card
                    >
                        <x-client.blog-card :post="$post"/>
                    </div>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('client/custom/css/favorites.css') }}"
    >
@endpush

@push('scripts')
    <script src="{{ asset('client/custom/js/favorites.js') }}"></script>
    <script src="{{ asset('client/custom/js/likes.js') }}"></script>
@endpush
