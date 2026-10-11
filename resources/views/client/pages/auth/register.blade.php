@extends('client.pages.auth.layout')

@section('auth-content')
    <section class="view" id="register">
                <h1>ایجاد حساب کاربری</h1>
                <p class="sub">با چند اطلاعات ساده عضو فودمارت شوید.</p>
                <form novalidate data-form="register">
                    <x-client.forms.input id="r-name" name="user_name" label="نام کاربری" placeholder="علی" autocomplete="username" />
                    <x-client.forms.input id="r-phone" name="phone" type="tel" label="شماره موبایل" dir="ltr" inputmode="numeric" placeholder="09120000000" autocomplete="tel" />
                    <x-client.forms.input id="r-pass" name="password" type="password" label="رمز عبور" placeholder="حداقل ۸ کاراکتر" autocomplete="new-password">
                        <div class="strength"><span id="bar"></span></div>
                    </x-client.forms.input>
                    <x-client.forms.input id="r-pass2" name="password_confirmation" type="password" label="تکرار رمز عبور" placeholder="تکرار رمز عبور" autocomplete="new-password" />

                    <div class="field"><x-client.checkbox name="terms" wrapperClass="m-0">
                            <a href="/terms" target="_blank">قوانین و مقررات</a> را می‌پذیرم
                        </x-client.checkbox><div class="err"></div></div>
                    <x-client.button class="w-100">ثبت‌نام</x-client.button>
                </form>
                <p class="switch">قبلاً ثبت‌نام کرده‌اید؟ <x-client.link href="{{ route('login') }}">وارد شوید</x-client.link></p>
            </section>
@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/register.js') }}"></script>
@endpush
