<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'پنل ادمین')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/src/assets/img/favicon.ico') }}"/>

    @include('admin.assets.css')
    @stack('styles')

</head>
<body class="layout-boxed">

<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>

@include('admin.partials.header')

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

    <div class="overlay"></div>
    <div class="search-overlay"></div>

    @include('admin.partials.sidebar')

    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="middle-content container-xxl p-0">
                @yield('content')
            </div>

        </div>
        @include('admin.partials.footer')
    </div>

</div>

@include('admin.assets.js')
@stack('scripts')

</body>
</html>
