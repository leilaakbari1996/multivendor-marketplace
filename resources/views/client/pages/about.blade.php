@extends('client.layouts.app')

@section('title', 'ارتباط با ما')


@push('styles')
    <link rel="stylesheet" href="{{ asset('client/custom/css/contact.css') }}">
    <style>
        /* ---- صفحه درباره ما ---- */
        .about-hero{background:var(--brand-soft);border-color:var(--brand-line)}
        .about-img{display:grid;place-items:center;min-height:300px;height:100%;border-radius:18px;font-size:5rem;
            background:linear-gradient(135deg,var(--brand-soft),#fde7b0);border:1px solid var(--brand-line)}
        .about-img img{width:100%;height:100%;min-height:300px;object-fit:cover;border-radius:18px}
        .stat-num{font-size:1.8rem;font-weight:700;color:var(--c-main-d);line-height:1.3}
        .about-card{transition:border-color .15s,transform .15s}
        .about-card:hover{border-color:var(--brand-line);transform:translateY(-2px)}
        .about-icon{display:grid;place-items:center;width:52px;height:52px;border-radius:50%;background:var(--brand-soft);color:var(--c-main-d)}
        .step-num{flex-shrink:0;display:grid;place-items:center;width:36px;height:36px;border-radius:50%;background:var(--c-main);color:#3a2a00;font-weight:700}
        footer{border-top:1px solid #ececec}
        @media (prefers-reduced-motion:reduce){.about-card{transition:none}.about-card:hover{transform:none}}
        @media (max-width:576px){.about-img{min-height:220px;font-size:4rem}.stat-num{font-size:1.5rem}}
    </style>
@endpush

@section('content')

<main class="container my-5">

    <x-client.page-hero title="{{ $settings['about_hero_title'] }}" description="{{ $settings['about_hero_description'] }}" icon="bi-shop" />

    <!-- داستان ما -->
    <section class="row g-4 align-items-center my-4">
        <div class="col-lg-6">
            <div class="card-box p-4 p-md-5 h-100">
                <h2 class="h5 fw-bold mb-3">داستان ما</h2>
                <p class="text-muted">

                    {!! $settings['about_our_story'] !!}

                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="about-img" role="img" aria-label="تصویر فروشگاه">
                <!-- <img src="img/about.jpg" alt="فروشگاه فودمارت" loading="lazy"> -->
                <span aria-hidden="true">🛒</span>
            </div>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <x-client.stat-box :value="$stats['products']"  label="محصول متنوع" />
        <x-client.stat-box :value="$stats['customers']" label="مشتری" />
        <x-client.stat-box :value="$stats['vendors']"   label="فروشنده همکار" />
        <x-client.stat-box :value="24"                  label="ساعت پشتیبانی در روز" />
    </section>


    <!-- ارزش‌ها -->
    <h2 class="h5 fw-bold text-center mt-5">چرا فودمارت؟</h2>

    @include('client.partials.home.shop-benefits')


    <!-- دعوت به اقدام -->
    <section class="card-box about-hero p-4 p-md-5 text-center">
        <h2 class="h5 fw-bold mb-2">{{ $settings['cta_shop_title'] ?? '' }}</h2>
        <p class="text-muted mb-4">{{ $settings['cta_shop_description'] ?? '' }}</p>
        <div class="d-flex justify-content-center  gap-2">
            <x-client.link :href="route('products.index')" :link="false" class="btn btn-brand px-3 px-sm-4">مشاهده محصولات</x-client.link>
            <x-client.link :href="route('contact')" :link="false" class="btn card-link px-3 px-sm-4">تماس با ما</x-client.link>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    $(function () {
        // شمارنده‌ی آمار: وقتی کارت وارد دید شد، از صفر تا مقدار نهایی بالا می‌رود
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const fa = (n) => Number(n).toLocaleString('fa-IR');

        $('.stat-num').each(function () {
            const $el = $(this), end = +$el.data('count'), suffix = $el.data('suffix') || '';
            $el.text(fa(end) + suffix);                    // مقدار نهایی (بدون JS هم درست است)
            if (reduce) return;

            let started = false;
            function check() {
                if (started) return;
                const top = $el.offset().top, view = $(window).scrollTop() + $(window).height();
                if (view > top + 40) {
                    started = true;
                    $({ v: 0 }).animate({ v: end }, {
                        duration: 1200,
                        step: function (now) { $el.text(fa(Math.round(now)) + suffix); },
                        complete: function () { $el.text(fa(end) + suffix); }
                    });
                    $(window).off('scroll.stat' + end, check);
                }
            }
            $(window).on('scroll.stat' + end, check);
            check();
        });
    });
</script>
@endpush
