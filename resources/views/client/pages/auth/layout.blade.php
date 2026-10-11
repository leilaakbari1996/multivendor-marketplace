<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ورود و ثبت‌نام</title>
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/root.css') }}"
    >
    <link href="{{ asset('fonts/Webfonts/fontiran.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('fonts/Webfonts/style.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('client/custom/css/auth.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/custom/css/general.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('client/custom/css/checkbox.css') }}">
    @include('assets.css.alert')
    @stack('styles')
</head>
<body>
<main>
    <div class="card">
        <div class="avatar" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg></div>
            @yield('auth-content')
    </div>
</main>
<script src="{{ asset('client/js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ asset('admin/custom/js/ajax.js') }}"></script>
@include('assets.js.alert')
@stack('scripts')
</body>
</html>
