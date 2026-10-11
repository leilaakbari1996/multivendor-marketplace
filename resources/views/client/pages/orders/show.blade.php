@extends('client.pages.users.layout')

@use('App\Enums\OrderStatus')
@use(App\Support\DateHelper)

@php
    // مراحل عادی یک سفارش؛ لغو/مرجوع خارج از این مسیر است
    $flow = [OrderStatus::PENDING, OrderStatus::PROCESSING, OrderStatus::SHIPPED, OrderStatus::DELIVERED];

    $current = array_search($order->status, $flow, true);       // false => لغو یا مرجوع
    if ($order->isDelivered()) {
        $current = count($flow);                                // همه مراحل تیک بخورند
    }

    $note = match ($order->status) {
        OrderStatus::CANCELLED => 'این سفارش  لغو شده است. ' ,
        OrderStatus::REFUNDED  => 'مبلغ این سفارش مرجوع شده است.',
        default                => null,
    };

    $address = $order->shipping_address;
@endphp

@section('profile-content')
    <section>

        <div class="order st-{{ $order->status->value }} p-4 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <a href="{{ route('profile.orders.index') }}" class="small text-secondary text-decoration-none">بازگشت به سفارش‌ها</a>
                    <h1 class="h5 fw-bold mt-2 mb-1">سفارش {{ $order->order_number }}</h1>
                    <div class="small text-secondary">ثبت‌شده در {{ DateHelper::toJalali($order->created_at,'Y/m/d - H:i') }}</div>
                </div>
                <span class="badge rounded-pill st-{{ $order->status->value }}">{{ $order->status->label() }}</span>
            </div>

            @if ($current !== false)
                <ol class="order-steps mt-4 mb-0">
                    @foreach ($flow as $i => $step)
                        <li class="{{ $i < $current ? 'done' : ($i === $current ? 'current' : '') }}">
                            <span class="dot">{{ $i < $current ? '✓' : number_format($i + 1) }}</span>
                            <span class="lbl">{{ $step->label() }}</span>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="mt-3 mb-0 small">{{ $note }}</p>
            @endif
        </div>

        <div class="row g-3">

            <div class="col-lg-8 d-flex flex-column gap-3">

                {{-- آیتم‌های سفارش --}}
                <div class="card-box p-4">
                    <h2 class="h6 fw-bold mb-3">کالاهای سفارش</h2>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr class="small text-secondary">
                                <th class="fw-normal">کالا</th>
                                <th class="fw-normal text-center">تعداد</th>
                                <th class="fw-normal text-nowrap">قیمت واحد</th>
                                <th class="fw-normal text-nowrap">مبلغ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->product_name }}
                                        @if ($item->discount_amount > 0)
                                            <div class="small text-danger">تخفیف {{ number_format($item->discount_amount) }} تومان</div>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format($item->quantity) }}</td>
                                    <td class="text-nowrap text-secondary">{{ number_format($item->price) }} تومان</td>
                                    <td class="text-nowrap fw-bold">{{ number_format($item->total) }} تومان</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- اطلاعات ارسال (اسنپ‌شات آدرس در لحظه ثبت سفارش) --}}
                @if ($address || $order->tracking_code)
                    <div class="card-box p-4">
                        <h2 class="h6 fw-bold mb-3">اطلاعات ارسال</h2>

                        @if ($address)
                            <div class="fw-bold mb-1">{{ $address['title'] ?? '' }}</div>
                            <div class="small mb-2">{{ $address['address'] ?? '' }}</div>
                            <div class="d-flex flex-wrap gap-3 small text-secondary">
                                @isset($address['postal_code'])<span>کدپستی: {{ $address['postal_code'] }}</span>@endisset
                                @isset($address['phone'])<span>{{ $address['phone'] }}</span>@endisset
                                @isset($address['receiver_name'])<span>{{ $address['receiver_name'] }}</span>@endisset
                            </div>
                        @endif

                        @if ($order->tracking_code)
                            <div class="foot-line d-flex justify-content-between align-items-center mt-3 pt-3">
                                <span class="text-secondary">کد رهگیری مرسوله</span>
                                <span class="chip">{{ $order->tracking_code }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- خلاصه مبلغ و پرداخت --}}
            <div class="col-lg-4">
                <div class="card-box p-4">
                    <h2 class="h6 fw-bold mb-3">خلاصه پرداخت</h2>

                    <div class="d-flex justify-content-between py-1 text-secondary">
                        <span>جمع کالاها</span>
                        <span class="text-body">{{ number_format($order->subtotal) }} تومان</span>
                    </div>

                    @if ($order->discount_amount > 0)
                        <div class="d-flex justify-content-between py-1 text-secondary">
                            <span>تخفیف</span>
                            <span class="text-danger">−{{ number_format($order->discount_amount) }} تومان</span>
                        </div>
                    @endif

                    @if ($order->coupon)
                        <div class="d-flex justify-content-between py-1 text-secondary">
                            <span>کد تخفیف</span>
                            <span class="chip">{{ $order->coupon->code }}</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between py-1 text-secondary">
                        <span>هزینه ارسال</span>
                        <span class="text-body">{{ $order->shipping_amount > 0 ? number_format($order->shipping_amount) . ' تومان' : 'رایگان' }}</span>
                    </div>

                    <div class="foot-line d-flex justify-content-between align-items-center mt-3 pt-3">
                        <b>مبلغ کل</b>
                        <b>{{ number_format($order->total) }} تومان</b>
                    </div>

                    @if ($order->paid_at)
                        <div class="border-top mt-3 pt-3 small">
                            @if ($order->paid_at)
                                <div class="d-flex justify-content-between py-1 text-secondary">
                                    <span>زمان پرداخت</span><span class="text-body">{{ $order->paid_at->format('Y/m/d - H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('client/custom/css/orders.css') }}">
@endpush
