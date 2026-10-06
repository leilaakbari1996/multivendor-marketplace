<div class="offcanvas-body d-flex flex-column">
    <ul class="list-group list-group-flush mb-3">
        @forelse ($cartItems as $item)
            <li class="list-group-item px-0 py-3">
                <div class="d-flex justify-content-between align-items-start gap-2">
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

                <div class="d-flex align-items-center justify-content-between gap-2 mt-3">
                    {{-- تغییر تعداد --}}
                    <form
                        action="{{ route('cart.update', $item->product_id) }}"
                        method="POST"
                        class="d-flex align-items-center gap-2">
                        @csrf
                        @method('PATCH')

                        <div class="input-group input-group-sm" style="width: 110px;" dir="ltr">
                            <button type="button" class="btn btn-outline-secondary" data-qty-minus>−</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                   min="0" max="{{ \App\Constants\Client\CartConstant::MAX_QUANTITY_PER_ITEM }}"
                                   class="form-control text-center">
                            <button type="button" class="btn btn-outline-secondary" data-qty-plus>+</button>
                        </div>

                        <button type="submit" class="btn btn-outline-primary btn-sm">بروزرسانی</button>
                    </form>

                    {{-- حذف --}}
                    <form
                        action="{{ route('cart.destroy', $item->product_id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1"
                                title="حذف از سبد">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                            </svg>
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
