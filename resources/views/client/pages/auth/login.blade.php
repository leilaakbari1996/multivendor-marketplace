@extends('client.pages.auth.layout')

@section('auth-content')
     <section class="view" id="login">
                <h1>ورود به حساب کاربری</h1>
                <p class="sub">شماره موبایل و رمز عبور خود را وارد کنید.</p>
                <form novalidate data-form="login">
                    <x-client.forms.input id="l-phone" name="phone" type="tel" label="شماره موبایل" dir="ltr" inputmode="numeric" placeholder="09120000000" autocomplete="tel" />
                    <x-client.forms.input id="l-pass" name="password" type="password" label="رمز عبور" placeholder="رمز عبور" autocomplete="current-password" />
                    <div class="row" style="margin-bottom: 10px">
                        <x-client.checkbox name="remember" label="مرا به خاطر بسپار" wrapperClass="m-0" checked />
                        <x-client.link href="{{ route('password.request') }}">فراموشی رمز عبور</x-client.link>
                    </div>
                    <x-client.button class="w-100">ورود</x-client.button>
                </form>
                <p class="switch">حساب کاربری ندارید؟
                    <x-client.link href="{{ route('register') }}">ثبت‌نام کنید</x-client.link>
                </p>
            </section>
@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/login.js') }}"></script>
@endpush
