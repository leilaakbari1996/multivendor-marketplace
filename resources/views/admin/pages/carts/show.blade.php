```blade
@extends('admin.layouts.app')

@push('styles')
    <link
        href="{{ asset('admin/src/assets/css/dark/apps/invoice-preview.css') }}"
        rel="stylesheet"
        type="text/css"
    />
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'سبدهای خرید',
                'url' => route('panel.cart.index'),
            ],
        ]"
        current="جزئیات سبد خرید"
    />

    <div class="row invoice layout-top-spacing layout-spacing">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="doc-container">

                <div class="row">

                    {{-- Cart Details --}}
                    <div class="col-xl-9">

                        <div class="invoice-container">

                            <div class="invoice-inbox">

                                <div id="ct">

                                    <div class="invoice-00001">

                                        <div class="content-section">

                                            {{-- Header --}}
                                            <div class="inv--head-section inv--detail-section">

                                                <div class="row">

                                                    <div class="col-sm-6 col-12 mr-auto">

                                                        <div class="d-flex align-items-center">

                                                            <h3 class="in-heading mb-0">
                                                                جزئیات سبد خرید
                                                            </h3>

                                                        </div>

                                                        <p class="inv-street-addr mt-3">
                                                            اطلاعات سبد خرید مشتری
                                                        </p>

                                                    </div>

                                                    <div class="col-sm-6 text-sm-end">

                                                        <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4">
                                                            <span class="inv-title">
                                                                شناسه سبد:
                                                            </span>

                                                            <span class="inv-number">
                                                                #{{ $cart->id }}
                                                            </span>
                                                        </p>

                                                        <p class="inv-created-date mt-sm-5 mt-3">
                                                            <span class="inv-title">
                                                                تاریخ ایجاد:
                                                            </span>

                                                            <span class="inv-date">
                                                                {{ \App\Support\DateHelper::toJalali($cart->created_at) }}
                                                            </span>
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Customer Details --}}
                                            <div class="inv--detail-section inv--customer-detail-section">

                                                <div class="row">

                                                    <div class="col-xl-8 col-lg-7 col-md-6 col-sm-6">

                                                        <p class="inv-to">
                                                            اطلاعات مشتری
                                                        </p>

                                                        <p class="inv-customer-name">
                                                            {{ $cart->user?->user_name ?? '-' }}
                                                        </p>

                                                        <p class="inv-street-addr">
                                                            شماره موبایل:
                                                            {{ $cart->user?->mobile ?? '-' }}
                                                        </p>

                                                    </div>

                                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6 text-sm-end">

                                                        <h6 class="inv-title">
                                                            اقلام سبد
                                                        </h6>

                                                        <p class="inv-customer-name">
                                                            {{ number_format($cart->items->count()) }}
                                                            محصول
                                                        </p>

                                                        <p class="inv-street-addr">
                                                            {{ number_format($cart->items->sum('quantity')) }}
                                                            کالا
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Cart Items --}}
                                            <div class="inv--product-table-section">

                                                <div class="table-responsive">

                                                    <table class="table">

                                                        <thead>
                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>محصول</th>
                                                            <th class="text-end">تعداد</th>
                                                            <th class="text-end">قیمت واحد</th>
                                                            <th class="text-end">مبلغ</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>

                                                        @forelse($cart->items as $item)

                                                            <tr>

                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>

                                                                <td>
                                                                    {{ $item->product?->name ?? '-' }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->quantity) }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->unitPrice()) }}
                                                                    تومان
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->totalPrice()) }}
                                                                    تومان
                                                                </td>

                                                            </tr>

                                                        @empty

                                                            <tr>
                                                                <td colspan="5" class="text-center">
                                                                    این سبد خرید خالی است.
                                                                </td>
                                                            </tr>

                                                        @endforelse

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>


                                            {{-- Cart Summary --}}
                                            <div class="inv--total-amounts">

                                                <div class="row mt-4">

                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                    </div>

                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">

                                                        <div class="text-sm-end">

                                                            <div class="row">

                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        تعداد محصولات:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($cart->items->count()) }}
                                                                    </p>
                                                                </div>


                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        تعداد کل کالاها:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($cart->items->sum('quantity')) }}
                                                                    </p>
                                                                </div>


                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        مبلغ کل:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <h4>
                                                                        {{ number_format($totalAmount) }}
                                                                        تومان
                                                                    </h4>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Note --}}
                                            <div class="inv--note">

                                                <div class="row mt-4">

                                                    <div class="col-sm-12">

                                                        <p>
                                                            این صفحه صرفاً جهت مشاهده جزئیات سبد خرید مشتری است.
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="col-xl-3">

                        <div class="invoice-actions-btn">

                            <div class="invoice-action-btn">

                                <div class="row">

                                    <div class="col-xl-12 col-md-4 col-sm-6">

                                        <a
                                            href="{{ route('panel.user.edit', $cart->user_id) }}"
                                            class="btn btn-primary w-100"
                                        >
                                            مشاهده مشتری
                                        </a>

                                    </div>

                                    <div class="col-xl-12 col-md-4 col-sm-6 mt-2">

                                        <a
                                            href="{{ route('panel.cart.index') }}"
                                            class="btn btn-secondary w-100"
                                        >
                                            بازگشت
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
```

این نسخه با Controller فعلی‌ات که `$totalAmount` را ارسال می‌کند، هماهنگ است و دیگر هیچ محاسبه‌ی قیمت یا `@php` داخل Blade ندارد.
