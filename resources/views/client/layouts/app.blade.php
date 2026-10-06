<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <title>@yield('title', 'FoodMart')</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="author" content="@yield('meta_author')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="description" content="@yield('meta_description')">

    @include('client.layouts.assets.css.styles')
    @stack('styles')
</head>

<body>
@include('client.layouts.svg')
@include('client.partials.cart.cart')
@include('client.layouts.header')

<main>
    @yield('content')
</main>

@include('client.layouts.footer')

@include('client.layouts.assets.js.scripts')
@stack('scripts')

</body>
</html>

