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
                'title' => 'سفارش‌ها',
                'url' => route('panel.order.index'),
            ],
        ]"
        current="جزئیات سفارش"
    />

    <div class="row invoice layout-top-spacing layout-spacing">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="doc-container">

                <div class="row">

                    {{-- Order Details --}}
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
                                                                جزئیات سفارش
                                                            </h3>

                                                        </div>

                                                        <p class="inv-street-addr mt-3">
                                                            اطلاعات سفارش مشتری
                                                        </p>

                                                    </div>

                                                    <div class="col-sm-6 text-sm-end">

                                                        <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4">

                                                            <span class="inv-title">
                                                                شماره سفارش:
                                                            </span>

                                                            <span class="inv-number">
                                                                #{{ $order->order_number }}
                                                            </span>

                                                        </p>

                                                        <p class="inv-created-date mt-sm-5 mt-3">

                                                            <span class="inv-title">
                                                                تاریخ ایجاد:
                                                            </span>

                                                            <span class="inv-date">
                                                                {{ \App\Support\DateHelper::toJalali($order->created_at) }}
                                                            </span>

                                                        </p>

                                                        <p class="mt-3">

                                                            <span class="inv-title">
                                                                وضعیت:
                                                            </span>

                                                            <span>
                                                                {!! \App\Support\BadgeHelper::button($order->status) !!}
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
                                                            {{ $order->user?->user_name ?? '-' }}
                                                        </p>

                                                        <p class="inv-street-addr">
                                                            شماره موبایل:
                                                            {{ $order->user?->mobile ?? '-' }}
                                                        </p>

                                                    </div>

                                                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-6 text-sm-end">

                                                        <h6 class="inv-title">
                                                            اقلام سفارش
                                                        </h6>

                                                        <p class="inv-customer-name">
                                                            {{ number_format($order->items->count()) }}
                                                            محصول
                                                        </p>

                                                        <p class="inv-street-addr">
                                                            {{ number_format($order->items->sum('quantity')) }}
                                                            کالا
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Order Items --}}
                                            <div class="inv--product-table-section">

                                                <div class="table-responsive">

                                                    <table class="table">

                                                        <thead>

                                                        <tr>
                                                            <th>ردیف</th>
                                                            <th>محصول</th>
                                                            <th>فروشنده</th>
                                                            <th class="text-end">تعداد</th>
                                                            <th class="text-end">قیمت واحد</th>
                                                            <th class="text-end">تخفیف</th>
                                                            <th class="text-end">مبلغ</th>
                                                        </tr>

                                                        </thead>

                                                        <tbody>

                                                        @forelse($order->items as $item)

                                                            <tr>

                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>

                                                                <td>
                                                                    {{ $item->product_name }}
                                                                </td>

                                                                <td>
                                                                    {{ $item->vendor?->store_name ?? '-' }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->quantity) }}
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->price) }}
                                                                    تومان
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->discount_amount * $item->quantity) }}
                                                                    تومان
                                                                </td>

                                                                <td class="text-end">
                                                                    {{ number_format($item->total) }}
                                                                    تومان
                                                                </td>

                                                            </tr>

                                                        @empty

                                                            <tr>
                                                                <td colspan="7" class="text-center">
                                                                    این سفارش فاقد آیتم است.
                                                                </td>
                                                            </tr>

                                                        @endforelse

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>


                                            {{-- Order Summary --}}
                                            <div class="inv--total-amounts">

                                                <div class="row mt-4">

                                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                    </div>

                                                    <div class="col-sm-7 col-12 order-sm-1 order-0">

                                                        <div class="text-sm-end">

                                                            <div class="row">

                                                                {{-- Product Count --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        تعداد محصولات:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($order->items->count()) }}
                                                                    </p>
                                                                </div>


                                                                {{-- Total Quantity --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        تعداد کل کالاها:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($order->items->sum('quantity')) }}
                                                                    </p>
                                                                </div>


                                                                {{-- Subtotal --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        مبلغ سفارش:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($order->subtotal) }}
                                                                        تومان
                                                                    </p>
                                                                </div>


                                                                {{-- Coupon Code --}}
                                                                @if($order->coupon)
                                                                    <div class="col-sm-8 col-7">
                                                                        <p>
                                                                            کد تخفیف:
                                                                        </p>
                                                                    </div>

                                                                    <div class="col-sm-4 col-5">
                                                                        <p>
                                                                            <span class="badge badge-light-primary">
                                                                                {{ number_format($couponDiscountAmount) }} تومان
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                @endif


                                                                {{-- Discount --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        تخفیف محصولات:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p class="text-danger">
                                                                        {{ number_format($itemDiscountAmount) }}
                                                                        تومان
                                                                    </p>
                                                                </div>


                                                                {{-- Shipping --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        هزینه ارسال:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">
                                                                    <p>
                                                                        {{ number_format($order->shipping_amount) }}
                                                                        تومان
                                                                    </p>
                                                                </div>


                                                                {{-- Total --}}
                                                                <div class="col-sm-8 col-7">
                                                                    <p>
                                                                        مبلغ نهایی:
                                                                    </p>
                                                                </div>

                                                                <div class="col-sm-4 col-5">

                                                                    <h4>
                                                                        {{ number_format($itemsTotal) }}
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
                                                            این صفحه صرفاً جهت مشاهده جزئیات سفارش مشتری است.
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

                                    {{-- Customer --}}
                                    <div class="col-xl-12 col-md-4 col-sm-6">

                                        @if($order->user)

                                            <a
                                                href="{{ route('panel.user.edit', $order->user_id) }}"
                                                class="btn btn-primary w-100"
                                            >
                                                مشاهده مشتری
                                            </a>

                                        @endif

                                        @if($order->coupon)

                                            <a
                                                href="{{ route('panel.coupon.edit', $order->coupon_id) }}"
                                                class="btn btn-primary w-100 mt-3"
                                            >
                                                {{ $order->coupon->code }} مشاهده کد تخفیف
                                            </a>

                                        @endif


                                    </div>


                                    {{-- Back --}}
                                    <div class="col-xl-12 col-md-4 col-sm-6 mt-2">

                                        <a
                                            href="{{ route('panel.order.index') }}"
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
