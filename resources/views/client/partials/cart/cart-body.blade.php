<div class="offcanvas-body d-flex flex-column">
    <ul class="list-group list-group-flush mb-3">
        @forelse ($cartItems as $item)
            <li class="list-group-item px-0 py-3 product-item">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="my-0 mb-1">{{ $item->product->name }}</h6>

                        <small class="text-body-secondary d-block">
                            {{ $item->quantity }} × {{ number_format($item->unitPrice()) }} تومان
                        </small>

                        @unless ($item->isAvailable())
                            <small class="text-danger d-block mt-1">موجودی کافی نیست</small>
                        @endunless
                    </div>

                    <span class="fw-semibold text-nowrap">
                            {{ number_format($item->totalPrice()) }} تومان
                        </span>
                </div>

                <div class="d-flex align-items-center justify-content-around gap-1 mt-3">
                    {{-- تغییر تعداد --}}
                    <form
                        data-product-id = {{ $item->product_id }}
                        action="{{ route('cart.update', $item->product_id) }}"
                        method="POST"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        @method('PATCH')
                        <x-client.product-qty :product="$item->product" :in-cart="$item->quantity" buttonType="submit" buttonText="بروزرسانی" />
                    </form>

                    {{-- حذف --}}
                    <form
                        data-product-id = {{ $item->product_id }}
                        class="pd-buy"
                        action="{{ route('cart.destroy', $item->product_id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn-cart"
                                style="padding: 0 15px"
                                title="حذف از سبد">
                            حذف
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center text-body-secondary py-5 border-0">
                سبد خرید شما خالی است
            </li>
        @endforelse
    </ul>

    @if ($cartItems->isNotEmpty())
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center border-top pt-3 mb-3">
                <span>مجموع</span>
                <strong class="fs-5" data-cart-total>{{ number_format($cartTotal) }} تومان</strong>
            </div>


            <a
                {{--                    href="{{ route('checkout.index') }}"--}}
                class="w-100 btn btn-lg cart-checkout-btn">
                ادامه و ثبت سفارش
            </a>
        </div>
    @endif
</div>
