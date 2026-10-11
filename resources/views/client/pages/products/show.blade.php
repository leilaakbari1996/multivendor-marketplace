@extends('client.layouts.app')

@section('title', 'محصولات')

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/product-show.css') }}"
    >
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('client/custom/css/breadcrumb.css') }}"
    >
@endpush

@section('content')
    <main class="pd" id="product" data-price="79000" data-old="95000" data-stock="45" data-id="2">
        <div class="container">

            <x-client.breadcrumb
                :items="array_filter([
                ['title' => 'فروشگاه', 'url' => url('/products')],
                $product->category
                    ? ['title' => $product->category->name, 'url' => url('/products') . '?' . http_build_query(['category' => $product->category->id])]
                    : null,
            ])"
                :current="$product->name"
            />

            <!-- بخش اصلی محصول -->
            <div class="card-box">
                <div class="row g-4 g-lg-5">

                    <!-- گالری (در RTL سمت راست) -->
                    <div class="col-12 col-md-6">
                        <div class="pd-main-img" id="mainImg">
                            @if($product->has_discount)
                                <span class="pd-badge">تخفیف</span>
                            @endif
                            <button class="pd-fav" id="favBtn" aria-label="افزودن به علاقه‌مندی‌ها"><i class="bi bi-heart"></i></button>
                            <!-- مسیر تصاویر را با تصاویر واقعی محصول جایگزین کنید -->
                            <img id="mainPic" src="{{ $product->image->url }}" alt="{{ $product->name }}">
                        </div>
                    </div>

                    <!-- اطلاعات -->
                    <div class="col-12 col-md-6">
                        <h1 class="pd-title">{{ $product->name }}</h1>
                        <div class="pd-meta">
                            <span><span class="pd-stars">★★★★☆</span> ۴٫۳ (۲۸ نظر)</span>
                            <span>دسته‌بندی: <a href="#" class="text-decoration-none" style="color:var(--c-main-d)">{{ $product->category->name }}</a></span>
                            <span class="pd-stock" id="stockTxt">{{ $product->stock }} عدد موجود</span>
                        </div>

                        <div class="pd-price">
                            <span class="now" id="priceNow">{{ number_format($product->final_price) }}</span>
                            <span class="unit">تومان</span>

                            @if($product->has_discount)
                                <span class="old">{{ number_format($product->price) }} تومان</span>
                                <span class="off" id="offTxt">{{ $product->discount_percent }}٪ تخفیف</span>
                            @endif
                        </div>

                        <p class="pd-desc">{{ $product->description }}</p>

                        <ul class="pd-features">
                            <li><i class="bi bi-flower1"></i> برداشت روز</li>
                            <li><i class="bi bi-box-seam"></i> بسته‌بندی بهداشتی</li>
                            <li><i class="bi bi-scale"></i> وزن: ۵۰۰ گرم</li>
                            <li><i class="bi bi-thermometer-snow"></i> نگهداری در یخچال</li>
                        </ul>

                        <div class="pd-buy">
                            @php
                                $inCart = $cartQuantities[$product->id] ?? 0;
                            @endphp
                            <x-client.product-qty :product="$product" :in-cart="$inCart" />
{{--                            <div class="pd-qty">--}}
{{--                                <button type="button" class="qty-plus" aria-label="افزایش">+</button>--}}
{{--                                <input type="text" class="qty-input" value="1" readonly aria-label="تعداد">--}}
{{--                                <button type="button" class="qty-minus" aria-label="کاهش" disabled>−</button>--}}
{{--                            </div>--}}
{{--                            <button type="button" class="btn-cart add-cart"><i class="bi bi-bag-plus"></i><span>افزودن به سبد</span></button>--}}
                            <div class="pd-total">مجموع: <b class="total-txt">79,000</b> تومان</div>
                        </div>

                        <div class="pd-trust">
                            <span><i class="bi bi-truck"></i>ارسال سریع در شیراز</span>
                            <span><i class="bi bi-arrow-repeat"></i>بازگشت وجه در صورت نارضایتی</span>
                            <span><i class="bi bi-shield-check"></i>پرداخت امن</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تب‌ها -->
            <div class="card-box mt-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#t-desc" type="button">توضیحات</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t-spec" type="button">مشخصات</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#t-rev" type="button">نظرات (۲۸)</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="t-desc">
                        <p>
                            {{ $product->description }}
                        </p>
                    </div>
                    <div class="tab-pane fade" id="t-spec">
                        <div class="table-responsive">
                            <table class="pd-spec">
                                <tr><td>وزن</td><td>۵۰۰ گرم</td></tr>
                                <tr><td>کشور / شهر مبدأ</td><td>ایران</td></tr>
                                <tr><td>شرایط نگهداری</td><td>یخچال، ۴ تا ۸ درجه</td></tr>
                                <tr><td>ماندگاری</td><td>۷ روز</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="t-rev">
                        <div class="pd-review"><div class="pd-avatar">م</div><div><b>محمد</b> <span class="pd-stars">★★★★★</span><div>خیلی تازه بود و بسته‌بندی عالی داشت.</div></div></div>
                        <div class="pd-review"><div class="pd-avatar">س</div><div><b>سارا</b> <span class="pd-stars">★★★★☆</span><div>کیفیت خوب بود، فقط کمی دیر رسید.</div></div></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- نوار خرید ثابت در موبایل -->
        <div class="pd-sticky">
            <div class="pr"><span class="total-txt">79,000</span> تومان<small>مجموع</small></div>
            <button type="button" class="btn-cart add-cart"><i class="bi bi-bag-plus"></i><span>افزودن به سبد</span></button>
        </div>
    </main>
    <div class="pd-toast" id="toast" role="status"></div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/custom/js/ajax.js') }}"></script>
    <script src="{{ asset('client/custom/js/filters.js') }}"></script>
@endpush


