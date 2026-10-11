@php
use App\Constants\AdminView;
@endphp
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="./index.html">
                        <img src="../src/assets/img/logo.svg" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="./index.html" class="nav-link"> CORK </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu active">
                <a href="{{ route(AdminView::PERFIX_ROUTE.'dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>{{ AdminView::DASHBOARD_TITLE }}</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#users" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>

                        <span>کاربران</span>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>

                <ul class="collapse submenu list-unstyled"
                    id="users"
                    data-bs-parent="#accordionExample">

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'user.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'user.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a href="#posts" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>

                        <span>مقالات</span>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>

                <ul class="collapse submenu list-unstyled"
                    id="posts"
                    data-bs-parent="#accordionExample">

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'post.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'post.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>
            </li>


            <li class="menu">
                <a href="#vendors" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-shopping-bag">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>

                        <span>فروشندگان</span>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>

                <ul class="collapse submenu list-unstyled"
                    id="vendors"
                    data-bs-parent="#accordionExample">

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'vendor.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'vendor.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>
            </li>

            <li class="menu">
                <a
                    href="#banners"
                    data-bs-toggle="collapse"
                    aria-expanded="true"
                    class="dropdown-toggle"
                >
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-image">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>

                        <span>بنرها</span>
                    </div>

                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="24"
                             height="24"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>

                <ul
                    class="collapse submenu list-unstyled"
                    id="banners"
                    data-bs-parent="#accordionExample"
                >
                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'banner.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'banner.index') }}">
                            لیست
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu">

                <a
                    href="#menus"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >

                    <div class="">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-menu"
                        >
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>

                        <span>منوها</span>

                    </div>

                    <div>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-chevron-right"
                        >
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>

                    </div>

                </a>

                <ul
                    class="collapse submenu list-unstyled"
                    id="menus"
                    data-bs-parent="#accordionExample"
                >

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'menu.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'menu.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>

            </li>

            <li class="menu">
                <a href="#categories" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span> دسته بندی ها</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="categories" data-bs-parent="#accordionExample">
                    <li class="">
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'category.create') }}"> ایجاد </a>
                    </li>
                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'category.index') }}"> لیست </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#products" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg"
                                 width="24"
                                 height="24"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="feather feather-package">
                                <path d="M16.5 9.4 7.55 4.24"></path>
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                        <span> محصولات</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="products" data-bs-parent="#accordionExample">
                    <li class="">
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'product.create') }}"> ایجاد </a>
                    </li>
                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'product.index') }}"> لیست </a>
                    </li>
                </ul>
            </li>

            <li class="menu">

                <a
                    href="#coupons"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >

                    <div class="">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-tag"
                        >
                            <path d="M20.59 13.41 11 3.83V3H4v7h.83l9.58 9.59a2 2 0 0 0 2.83 0l3.35-3.35a2 2 0 0 0 0-2.83z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>

                        <span>کدهای تخفیف</span>

                    </div>

                    <div>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-chevron-right"
                        >
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>

                    </div>

                </a>

                <ul
                    class="collapse submenu list-unstyled"
                    id="coupons"
                    data-bs-parent="#accordionExample"
                >

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'coupon.create') }}">
                            ایجاد
                        </a>
                    </li>

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'coupon.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>

            </li>

            <li class="menu">

                <a
                    href="#contact"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >

                    <div class="">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-inbox"
                        >
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                            <path d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                        </svg>

                        <span>پیام های دریافتی</span>

                    </div>

                    <div>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-chevron-right"
                        >
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>

                    </div>

                </a>

                <ul
                    class="collapse submenu list-unstyled"
                    id="contact"
                    data-bs-parent="#accordionExample"
                >

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE.'contacts.index') }}">
                            لیست
                        </a>
                    </li>

                </ul>

            </li>

            <li class="menu">
                <a
                    href="{{ route(AdminView::PERFIX_ROUTE . 'cart.index') }}"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-shopping-cart"
                        >
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>

                        <span>سبدهای خرید</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a
                    href="{{ route(AdminView::PERFIX_ROUTE . 'order.index') }}"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-shopping-bag"
                        >
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>

                        <span>سفارش‌ها</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a
                    href="{{ route(AdminView::PERFIX_ROUTE . 'media.index') }}"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >
                    <div class="">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-image"
                        >
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>

                        <span>رسانه ها</span>
                    </div>
                </a>
            </li>

            <li class="menu">

                <a
                    href="#settings"
                    data-bs-toggle="collapse"
                    aria-expanded="false"
                    class="dropdown-toggle"
                >

                    <div class="">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-settings"
                        >
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.6 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.6a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9c.14.6.7 1 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"
                            ></path>
                        </svg>

                        <span>تنظیمات</span>

                    </div>

                    <div>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-chevron-right"
                        >
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>

                    </div>

                </a>

                <ul
                    class="collapse submenu list-unstyled"
                    id="settings"
                    data-bs-parent="#accordionExample"
                >

                    <li>
                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'setting.index') }}">
                            تنظیمات سایت
                        </a>
                    </li>

                </ul>

            </li>


            {{--            <li class="menu">--}}
{{--                <a href="#roles" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">--}}
{{--                    <div class="">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                             width="24"--}}
{{--                             height="24"--}}
{{--                             viewBox="0 0 24 24"--}}
{{--                             fill="none"--}}
{{--                             stroke="currentColor"--}}
{{--                             stroke-width="2"--}}
{{--                             stroke-linecap="round"--}}
{{--                             stroke-linejoin="round"--}}
{{--                             class="feather feather-shield">--}}
{{--                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>--}}
{{--                        </svg>--}}
{{--                        <span> نقش‌ها</span>--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                             width="24"--}}
{{--                             height="24"--}}
{{--                             viewBox="0 0 24 24"--}}
{{--                             fill="none"--}}
{{--                             stroke="currentColor"--}}
{{--                             stroke-width="2"--}}
{{--                             stroke-linecap="round"--}}
{{--                             stroke-linejoin="round"--}}
{{--                             class="feather feather-chevron-right">--}}
{{--                            <polyline points="9 18 15 12 9 6"></polyline>--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <ul class="collapse submenu list-unstyled"--}}
{{--                    id="roles"--}}
{{--                    data-bs-parent="#accordionExample">--}}

{{--                    <li>--}}
{{--                        <a href="{{ route(AdminView::PERFIX_ROUTE.'role.create') }}">--}}
{{--                            ایجاد--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a href="{{ route(AdminView::PERFIX_ROUTE.'role.index') }}">--}}
{{--                            لیست--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                </ul>--}}
{{--            </li>--}}

{{--            <li class="menu">--}}
{{--                <a href="#permissions" data-bs-toggle="collapse" aria-expanded="true" class="dropdown-toggle">--}}
{{--                    <div class="">--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                             width="24"--}}
{{--                             height="24"--}}
{{--                             viewBox="0 0 24 24"--}}
{{--                             fill="none"--}}
{{--                             stroke="currentColor"--}}
{{--                             stroke-width="2"--}}
{{--                             stroke-linecap="round"--}}
{{--                             stroke-linejoin="round"--}}
{{--                             class="feather feather-key">--}}
{{--                            <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.778-7.778z"></path>--}}
{{--                            <path d="m15.5 7.5 3 3L22 7l-3-3"></path>--}}
{{--                            <path d="m13 9 2 2"></path>--}}
{{--                        </svg>--}}

{{--                        <span> دسترسی‌ها</span>--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                             width="24"--}}
{{--                             height="24"--}}
{{--                             viewBox="0 0 24 24"--}}
{{--                             fill="none"--}}
{{--                             stroke="currentColor"--}}
{{--                             stroke-width="2"--}}
{{--                             stroke-linecap="round"--}}
{{--                             stroke-linejoin="round"--}}
{{--                             class="feather feather-chevron-right">--}}
{{--                            <polyline points="9 18 15 12 9 6"></polyline>--}}
{{--                        </svg>--}}
{{--                    </div>--}}
{{--                </a>--}}

{{--                <ul class="collapse submenu list-unstyled"--}}
{{--                    id="permissions"--}}
{{--                    data-bs-parent="#accordionExample">--}}

{{--                    <li>--}}
{{--                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'permission.create') }}">--}}
{{--                            ایجاد--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a href="{{ route(AdminView::PERFIX_ROUTE . 'permission.index') }}">--}}
{{--                            لیست--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                </ul>--}}
{{--            </li>--}}

        </ul>

    </nav>

</div>
