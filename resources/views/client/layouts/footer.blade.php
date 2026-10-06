
<footer class="py-5">
    <div class="container-fluid">
        <div class="row">

            {{-- Site Info --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">

                    @if($siteSettings['site_logo'])
                        <img
                            src="{{ $siteSettings['site_logo'] }}"
                            alt="{{ $siteSettings['site_name'] }}"
                            class="img-fluid"
                        >
                    @endif

                    @if($siteSettings['site_description'])
                        <p class="mt-4">
                            {{ $siteSettings['site_description'] }}
                        </p>
                    @endif

                    <div class="social-links mt-4">
                        <ul class="d-flex list-unstyled gap-2">

                            @if(!empty($siteSettings['social_facebook']))
                                <li>
                                    <a
                                        href="{{ $siteSettings['social_facebook'] }}"
                                        class="btn btn-outline-light"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="فیسبوک"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                fill="currentColor"
                                                d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($siteSettings['social_telegram']))
                                <li>
                                    <a
                                        href="{{ $siteSettings['social_telegram'] }}"
                                        class="btn btn-outline-light"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="تلگرام"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                fill="currentColor"
                                                d="M21.92 3.6 18.6 20.1c-.25 1.17-.9 1.46-1.82.91l-5-3.68-2.41 2.32c-.27.27-.5.5-1.02.5l.36-5.1 9.28-8.38c.4-.36-.09-.56-.62-.2L5.9 13.7.96 12.15c-1.08-.34-1.1-1.08.23-1.57L20.5 3.05c.9-.33 1.7.2 1.42.55Z"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($siteSettings['social_youtube']))
                                <li>
                                    <a
                                        href="{{ $siteSettings['social_youtube'] }}"
                                        class="btn btn-outline-light"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="یوتیوب"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                fill="currentColor"
                                                d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            @endif

                            @if(!empty($siteSettings['social_instagram']))
                                <li>
                                    <a
                                        href="{{ $siteSettings['social_instagram'] }}"
                                        class="btn btn-outline-light"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="اینستاگرام"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                fill="currentColor"
                                                d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 1.77-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>

            {{-- Dynamic Footer Menus --}}
            @foreach($footerMenus as $footerMenu)
                <div class="col-md-2 col-sm-6">
                    <div class="footer-menu">

                        <h5 class="widget-title">
                            {{ $footerMenu->title }}
                        </h5>

                        @if($footerMenu->children->isNotEmpty())
                            <ul class="menu-list list-unstyled">
                                @foreach($footerMenu->children as $menuItem)
                                    <li class="menu-item">
                                        <a
                                            href="{{ $menuItem->url ?: '#' }}"
                                            class="nav-link"
                                        >
                                            {{ $menuItem->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            @endforeach

            {{-- Contact --}}
            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">

                    <h5 class="widget-title">
                        ارتباط با ما
                    </h5>

                    <ul class="menu-list list-unstyled">

                        @if($siteSettings['contact_phone'])
                            <li class="menu-item">
                                <a
                                    href="tel:{{ $siteSettings['contact_phone'] }}"
                                    class="nav-link"
                                >
                                    {{ $siteSettings['contact_phone'] }}
                                </a>
                            </li>
                        @endif

                        @if($siteSettings['contact_email'])
                            <li class="menu-item">
                                <a
                                    href="mailto:{{ $siteSettings['contact_email'] }}"
                                    class="nav-link"
                                >
                                    {{ $siteSettings['contact_email'] }}
                                </a>
                            </li>
                        @endif

                        @if($siteSettings['contact_address'])
                            <li class="menu-item">
                                <span class="nav-link">
                                    {{ $siteSettings['contact_address'] }}
                                </span>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">

                    <h5 class="widget-title">
                        عضویت در خبرنامه
                    </h5>

                    <p>
                        برای دریافت آخرین اخبار، تخفیف‌ها و پیشنهادهای ویژه عضو خبرنامه شوید.
                    </p>

                    <form
                        class="d-flex mt-3 gap-0 newsletter-form"
                        action="{{ route('newsletter.subscribe') }}"
                        method="POST"
                    >
                        @csrf

                        <input
                            class="form-control rounded-start rounded-0 bg-light"
                            type="email"
                            name="email"
                            placeholder="ایمیل شما"
                            aria-label="ایمیل شما"
                            required
                        >

                        <button
                            class="btn btn-dark rounded-end rounded-0"
                            type="submit"
                        >
                            عضویت
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</footer>

{{-- Footer Bottom --}}
<div id="footer-bottom">
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-md-6 copyright">
                <p class="mb-0">
                    © {{ now()->year }}
                    {{ $siteSettings['site_name'] }}
                    . {{ $siteSettings['footer_copyright'] }}
                </p>
            </div>

            <div class="col-md-6 credit-link text-start text-md-end">
                @if($siteSettings['contact_phone'])
                    <p class="mb-0">
                        تلفن تماس:
                        {{ $siteSettings['contact_phone'] }}
                    </p>
                @endif
            </div>

        </div>
    </div>
</div>

