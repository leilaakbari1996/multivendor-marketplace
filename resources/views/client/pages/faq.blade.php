@extends('client.layouts.app')

@section('title', 'ارتباط با ما')


@push('styles')
    <link rel="stylesheet" href="{{ asset('client/custom/css/contact.css') }}">
    <style>

        .box{background:#fff;border:1px solid var(--c-line);border-radius:16px}

        /* هدر */
        .page-hero{background:linear-gradient(135deg,var(--c-soft) 0%,#fff 70%);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;gap:24px}
        .page-hero h1{font-size:1.7rem;font-weight:700;color:#555;margin:0 0 10px}
        .page-hero p{color:var(--c-mute);font-size:.8rem;line-height:2;margin:0 0 14px;max-width:560px}
        .crumb{font-size:.7rem;color:var(--c-mute)}
        .crumb b{color:var(--c-ink)}
        .hero-ico{font-size:4.2rem;color:var(--c-main);line-height:1}

        /* جستجو */
        .search-wrap{position:relative;max-width:420px;margin-bottom:14px}
        .search-wrap i{position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--c-mute)}
        .search-wrap input{width:100%;border:1px solid var(--c-line);background:#fff;border-radius:10px;padding:10px 40px 10px 14px;font-size:.8rem;font-family:inherit}
        .search-wrap input:focus{outline:0;border-color:var(--brand-line);box-shadow:0 0 0 3px var(--brand-soft)}

        /* دسته‌ها */
        .chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px}
        .chip{border:1px solid var(--c-line);background:#fff;color:var(--c-mute);font-size:.75rem;padding:7px 16px;border-radius:20px;font-family:inherit;transition:.15s}
        .chip:hover{background:var(--c-bg);color:var(--c-ink)}
        .chip.active{background:var(--c-soft);border-color:var(--brand-line);color:var(--c-ink);font-weight:500}

        /* آکاردئون */
        .faq-card{padding:10px 24px}
        .faq-item{border-bottom:1px solid var(--c-line)}
        .faq-item:last-child{border-bottom:0}
        .faq-q{width:100%;background:none;border:0;display:flex;align-items:center;gap:12px;padding:18px 0;text-align:right;font-family:inherit;font-size:.88rem;font-weight:500;color:var(--c-ink)}
        .faq-q .ico-circle{margin:0;flex-shrink:0}
        .faq-q .txt{flex:1}
        .faq-q .arrow{color:var(--c-mute);transition:transform .2s}
        .faq-q:not(.collapsed) .arrow{transform:rotate(180deg);color:var(--c-main)}
        .faq-q:not(.collapsed) .txt{color:var(--c-main-d)}
        .faq-a{padding:0 54px 18px 0;font-size:.82rem;color:#555;line-height:2.1}
        .faq-a ul{padding-right:20px;margin:6px 0 0}
        .faq-a li::marker{color:var(--c-main)}
        .ico-circle{width:36px;height:36px;border-radius:50%;background:var(--c-soft);border:1px solid var(--brand-line);color:var(--c-main);display:inline-flex;align-items:center;justify-content:center;font-size:.95rem}

        .empty{display:none;text-align:center;padding:40px 16px;color:var(--c-mute);font-size:.82rem}
        .empty i{font-size:2rem;color:var(--brand-line);display:block;margin-bottom:8px}

        /* کارت پایانی */
        .cta-box{padding:22px 26px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;background:linear-gradient(135deg,var(--c-soft),#fff)}
        .cta-box h6{font-weight:700;color:#555;margin:0 0 4px;font-size:.9rem}
        .cta-box p{margin:0;font-size:.75rem;color:var(--c-mute)}
        .btn-main{background:var(--c-main);border:0;color:#fff;font-weight:700;font-size:.8rem;padding:10px 26px;border-radius:10px}
        .btn-main:hover{background:var(--c-main-d);color:#fff}

        @media(max-width:767px){
            .page-hero{padding:22px 18px}
            .hero-ico{display:none}
            .faq-card{padding:6px 16px}
            .faq-a{padding-right:0}
        }
    </style>
@endpush

@section('content')

    <main class="container my-5">

        <x-client.page-hero title="{{ $settings['faq_hero_title'] }}" description="{{ $settings['faq_hero_description'] }}" icon="bi-shop" />

            <!-- دسته‌ها -->
            <div class="chips mt-3" id="chips">
                <button class="chip active" data-cat="all">همه</button>
                @foreach($categories as $category)
                    <button class="chip" data-cat="{{ $category->id }}">{{ $category->name }}</button>
                @endforeach
            </div>

            <!-- سوالات -->
            <section class="box faq-card">
                <div class="accordion accordion-flush" id="faqList"></div>
                <div class="empty" id="faqEmpty"><i class="bi bi-search"></i>نتیجه‌ای پیدا نشد. عبارت دیگری را امتحان کنید یا با پشتیبانی تماس بگیرید.</div>
            </section>

            <!-- پشتیبانی -->
            <div class="box cta-box mt-3">
                <div>
                    <h6>هنوز سؤالی دارید؟</h6>
                    <p>پشتیبانی فودمارت شنبه تا جمعه، ۸ تا ۲۲ پاسخگوی شماست.</p>
                </div>
                <a href="{{ route('contact') }}" class="btn btn-main">تماس با ما</a>
            </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(function () {
            // برای افزودن سوال جدید فقط یک آیتم به این آرایه اضافه کنید
            var faqs = [
                { cat:'order', icon:'bi-bag-check', q:'چطور سفارش ثبت کنم؟',
                    a:'کالاها را به سبد خرید اضافه کنید، آدرس و شماره تماس را وارد کنید و پرداخت را نهایی کنید. پس از ثبت، پیامک تأیید برایتان ارسال می‌شود.' },
                { cat:'order', icon:'bi-pencil-square', q:'آیا می‌توانم سفارش را بعد از ثبت تغییر دهم؟',
                    a:'تا قبل از تحویل سفارش به پیک، با پشتیبانی تماس بگیرید تا کالاها یا آدرس را اصلاح کنیم. پس از خروج پیک، تغییر ممکن نیست.' },
                { cat:'order', icon:'bi-box-seam', q:'اگر کالایی ناموجود شد چه می‌شود؟',
                    a:'در این حالت با شما تماس می‌گیریم. می‌توانید کالای جایگزین انتخاب کنید یا آن را از سفارش حذف کنید؛ مبلغ کالای حذف‌شده برگردانده می‌شود.' },
                { cat:'pay', icon:'bi-credit-card', q:'روش‌های پرداخت چیست؟',
                    a:'پرداخت آنلاین از طریق درگاه بانکی و در صورت فعال بودن، پرداخت در محل هنگام تحویل.' },
                { cat:'pay', icon:'bi-cash-coin', q:'پول از حسابم کم شد ولی سفارش ثبت نشد، چه کنم؟',
                    a:'نگران نباشید. مبلغ کسرشده معمولاً ظرف چند روز کاری به حساب شما برمی‌گردد. اگر دیرتر شد، با ذکر شماره پیگیری بانکی با پشتیبانی تماس بگیرید.' },
                { cat:'ship', icon:'bi-truck', q:'سفارش چه ساعاتی تحویل داده می‌شود؟',
                    a:'ارسال سفارش‌ها شنبه تا جمعه، ساعت ۸ تا ۲۲ انجام می‌شود. زمان تقریبی تحویل پیش از نهایی کردن سفارش نمایش داده می‌شود.' },
                { cat:'ship', icon:'bi-geo-alt', q:'به کدام مناطق ارسال دارید؟',
                    a:'در حال حاضر ارسال در محدوده شهر شیراز انجام می‌شود. محدوده‌های جدید در همین بخش اطلاع‌رسانی خواهد شد.' },
                { cat:'ship', icon:'bi-telephone', q:'پیک به تماسم پاسخ نداد، چه کنم؟',
                    a:'با شماره پشتیبانی تماس بگیرید تا وضعیت سفارش و موقعیت پیک را بررسی کنیم.' },
                { cat:'return', icon:'bi-arrow-repeat', q:'در چه شرایطی می‌توانم کالا را مرجوع کنم؟',
                    a:'<ul><li>کالا خراب، فاسد یا تاریخ‌گذشته باشد.</li><li>کالای ارسالی با سفارش شما متفاوت باشد.</li><li>درخواست حداکثر ۲۴ ساعت پس از تحویل و همراه با عکس کالا ثبت شود.</li></ul>' },
                { cat:'return', icon:'bi-wallet2', q:'پول کالای مرجوعی چه زمانی برمی‌گردد؟',
                    a:'پس از تأیید مرجوعی توسط کارشناسان، مبلغ به همان روش پرداخت به شما برگردانده می‌شود.' },
                { cat:'account', icon:'bi-person-check', q:'برای خرید باید حتماً ثبت‌نام کنم؟',
                    a:'بله. ثبت‌نام فقط با شماره موبایل و کد تأیید انجام می‌شود و چند ثانیه بیشتر زمان نمی‌برد.' },
                { cat:'account', icon:'bi-shield-lock', q:'اطلاعات من نزد فودمارت امن است؟',
                    a:'اطلاعات شما فقط برای پردازش سفارش، ارسال و پشتیبانی استفاده می‌شود و بدون اجازه شما در اختیار دیگران قرار نمی‌گیرد. جزئیات در صفحه <a href="terms.html">قوانین و شرایط</a> آمده است.' }
            ];

            var $list = $('#faqList'), cat = 'all';

            // ساخت آکاردئون
            $.each(faqs, function (i, f) {
                $list.append(
                    '<div class="faq-item" data-cat="' + f.cat + '">' +
                    '<button class="faq-q collapsed" data-bs-toggle="collapse" data-bs-target="#a' + i + '" aria-expanded="false">' +
                    '<span class="ico-circle"><i class="bi ' + f.icon + '"></i></span>' +
                    '<span class="txt">' + f.q + '</span>' +
                    '<i class="bi bi-chevron-down arrow"></i>' +
                    '</button>' +
                    '<div id="a' + i + '" class="collapse" data-bs-parent="#faqList">' +
                    '<div class="faq-a">' + f.a + '</div>' +
                    '</div>' +
                    '</div>'
                );
            });

            // فیلتر دسته + جستجو
            function apply() {
                var term = $.trim($('#faqSearch').val()).toLowerCase(), shown = 0;
                $list.find('.faq-item').each(function () {
                    var $it = $(this),
                        okCat = cat === 'all' || $it.data('cat') === cat,
                        okTxt = !term || $it.text().toLowerCase().indexOf(term) > -1,
                        show = okCat && okTxt;
                    $it.toggle(show);
                    if (show) shown++;
                });
                $('#faqEmpty').toggle(shown === 0);
            }

            $('#chips').on('click', '.chip', function () {
                $('.chip').removeClass('active');
                $(this).addClass('active');
                cat = $(this).data('cat');
                apply();
            });
            $('#faqSearch').on('input', apply);
        });
    </script>
@endpush
