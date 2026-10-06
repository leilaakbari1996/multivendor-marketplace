@extends('client.layouts.app')

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/product-qty.css') }}"
    >
@endpush
@section('content')

    @include('client.partials.home.banner')

    @include('client.partials.home.category')

    @include('client.partials.home.featured-products')

    @include('client.partials.home.promo-banners', [
        'promoBanners' => $banners['promo'],
    ])

    @include('client.partials.home.best-selling-products')

    @include('client.partials.home.discount-newsletter')

    @include('client.partials.home.blog')

    @include('client.partials.home.shop-benefits')

@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/likes.js') }}"></script>
@endpush

