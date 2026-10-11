@php
use App\Support\AuthUser;
@endphp
<header dir="rtl">
    <div class="container-fluid">
        <div class="row py-3 border-bottom">

            {{-- Logo --}}
            <div class="col-sm-4 col-lg-3 text-center text-sm-end">
                <div class="main-logo">
                    <a href="{{ route('home') }}">
                        <img
                            src="{{ $siteSettings['site_logo'] ?? null }}"
                            alt="{{ $siteSettings['site_name'] ?? 'لوگو' }}"
                            class="img-fluid"
                        >
                    </a>
                </div>
            </div>

            {{-- Search --}}
            <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-6 d-none d-lg-block">
                @include('client.layouts.search')
            </div>

            {{--  User Actions --}}
            <div class="col-sm-8 col-lg-3 d-flex justify-content-center justify-content-sm-end gap-5 align-items-center  mt-4 mt-sm-0">

                {{-- User Actions --}}
                <ul class="d-flex justify-content-end list-unstyled m-0">

                    <li>
                        @if(AuthUser::check())

                            <a
                                href="{{ route('profile.index') }}"
                                class="rounded-circle bg-light p-2 mx-1"
                                aria-label="حساب کاربری"
                                title="{{ AuthUser::user()->user_name ?: 'حساب کاربری' }}"
                            >
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#user"></use>
                            </svg>
                            </a>
                        @else

                            <a
                                href="{{ route('login') }}"
                                class="rounded-circle bg-light p-2 mx-1"
                                aria-label="ورود به حساب کاربری"
                                title="ورود / ثبت‌نام"
                                >
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg>
                            </a>
                        @endif
                    </li>

                    @if(AuthUser::check())
                        <li>
                            <a
                                href="{{ route('profile.likes') }}"
                                class="rounded-circle bg-light p-2 mx-1"
                                aria-label="علاقه‌مندی‌ها"
                            >
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg>
                            </a>
                        </li>

                        <li class="d-lg-none">
                            <a
                                href="#"
                                class="rounded-circle bg-light p-2 mx-1"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart"
                                aria-label="سبد خرید"
                            >
                                <svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#cart"></use>
                                </svg>
                            </a>
                        </li>

                    @endif

                    <li class="d-lg-none">
                        <a
                            href="#"
                            class="rounded-circle bg-light p-2 mx-1"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasSearch"
                            aria-controls="offcanvasSearch"
                            aria-label="جستجو"
                        >
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <use xlink:href="#search"></use>
                            </svg>
                        </a>
                    </li>

                </ul>

                {{-- Cart --}}
                @if(AuthUser::check())
                    <div class="cart text-start d-none d-lg-block dropdown">

                    <button
                        class="border-0 bg-transparent d-flex flex-column gap-2 lh-1"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasCart"
                        aria-controls="offcanvasCart"
                    >
        <span class="fs-6 text-muted dropdown-toggle d-flex align-items-center gap-2">
            سبد خرید شما
            <span class="badge bg-primary rounded-pill" data-cart-count>{{ $cartCount }}</span>
        </span>

                        <span
                            class="cart-total fs-5 fw-bold"
                            data-cart-total
                        >
            {{ number_format($cartTotal) }} تومان
        </span>
                    </button>

                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Main Navigation --}}
    <div class="container-fluid">
        <div class="row py-3">

            <div class="d-flex justify-content-center justify-content-sm-between align-items-center">

                <nav class="main-menu d-flex navbar navbar-expand-lg">

                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar"
                        aria-controls="offcanvasNavbar"
                        aria-label="باز کردن منو"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div
                        class="offcanvas offcanvas-end"
                        tabindex="-1"
                        id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel"
                    >

                        <div class="offcanvas-header justify-content-center">

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="offcanvas"
                                aria-label="بستن"
                            ></button>

                        </div>

                        <div class="offcanvas-body">

                            @include('client.layouts.menu')

                        </div>

                    </div>

                </nav>

            </div>

        </div>
    </div>
</header>
