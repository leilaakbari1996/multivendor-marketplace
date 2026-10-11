
<div class="row g-3">
    @forelse ($orders as $order)
        <div class="col-12">
            <article class="order st-{{ $order->status->value }} p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <b>سفارش {{ $order->order_number }}</b>
                        {{-- اگر از تاریخ شمسی استفاده می‌کنی: verta($order->created_at)->format('Y/m/d') --}}
                        <small class="text-secondary me-2">{{ $order->created_at->format('Y/m/d') }}</small>
                    </div>
                    <span class="badge rounded-pill st-{{ $order->status->value }}">{{ $order->status->label() }}</span>
                </div>

                {{-- خلاصه آیتم‌ها: حداکثر ۴ مورد، بقیه با +N --}}
                <div class="d-flex flex-wrap gap-2 small text-secondary">
                    @foreach ($order->items->take(4) as $item)
                        <span class="chip">{{ $item->product_name }}</span>
                    @endforeach
                    @if ($order->items->count() > 4)
                        <span class="chip">+{{ P::fa($order->items->count() - 4) }}</span>
                    @endif
                </div>

                {{-- جزئیات --}}
                <div class="collapse small mt-3" id="order-{{ $order->id }}">
                    @foreach ($order->items as $item)
                        <div class="d-flex justify-content-between py-1 text-secondary">
                            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                            <span class="text-body">{{ number_format($item->total) }} تومان</span>
                        </div>
                    @endforeach

                    <div class="border-top mt-2 pt-2">
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
                        <div class="d-flex justify-content-between py-1 text-secondary">
                            <span>هزینه ارسال</span>
                            <span class="text-body">
                                {{ $order->shipping_amount > 0 ? number_format($order->shipping_amount) . ' تومان' : 'رایگان' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="foot-line d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3 pt-3">
                    <div class="text-secondary">
                        مبلغ کل <b class="text-body me-1">{{ number_format($order->total) }} تومان</b>
                    </div>
                    <div class="d-flex gap-4 small">
                        <button type="button"
                                class="btn btn-link p-0 text-secondary text-decoration-none small"
                                data-bs-toggle="collapse"
                                data-bs-target="#order-{{ $order->id }}"
                                aria-expanded="false">
                            جزئیات
                        </button>

                        <a href="{{ route('profile.orders.show', $order->order_number) }}"
                           class="btn btn-link p-0 link-hot text-decoration-none small">مشاهده سفارش</a>
                    </div>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-box d-flex flex-column align-items-center justify-content-center gap-3 text-secondary">
                <div>
                    {{ $status ? 'سفارشی با وضعیت «' . $status->label() . '» ندارید' : 'هنوز سفارشی ثبت نکرده‌اید' }}
                </div>
                <a href="{{ url('/') }}" class="btn btn-brand px-4">رفتن به فروشگاه</a>
            </div>
        </div>
    @endforelse
</div>

@if ($orders->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endif
