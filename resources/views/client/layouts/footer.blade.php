
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
                            <x-client.social-links :settings="$siteSettings" wrapperClass="d-flex list-unstyled gap-2" />
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
                        class="d-flex mt-3 gap-0 newsletter-form w-100"
                        action="{{ route('newsletter.subscribe') }}"
                        method="POST"
                    >
                        @csrf

                        <x-client.forms.input
                            name="email"
                            id="email-footer"
                            type="email"
                            placeholder="ایمیل شما"
                            class="newsletter-input"
                            required
                        />

                        <x-client.button
                            type="submit"
                            variant="dark"
                            class="btn-lg rounded-end-0"
                            width="auto"
                        >
                            عضویت
                        </x-client.button>

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

