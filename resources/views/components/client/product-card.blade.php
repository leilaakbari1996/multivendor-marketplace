
@php
    $inCart = $cartQuantities[$product->id] ?? 0;
    $url = route('products.show',$product->slug) ;
@endphp
<div class="product-item position-relative">

    {{-- Discount --}}
    @if($product->has_discount)

        <span class="badge bg-success position-absolute top-0 start-0 m-3">
            تخفیف
        </span>

    @endif

    {{-- Wishlist --}}
    <x-client.like-button
        type="product"
        :id="$product->id"
        :is-liked="$product->likes->isNotEmpty()"
    />

    {{-- Product Image --}}
    <figure>

        <a
            href="{{ $url }}"
            title="{{ $product->name }}"
        >
            @if($product->image)

                <img
                    src="{{ $product->image->url }}"
                    alt="{{ $product->name }}"
                    class="tab-image"
                >

            @endif
        </a>

    </figure>

    {{-- Product Name --}}
    <h3>
        <a href="{{ $url }}">
            {{ $product->name }}
        </a>
    </h3>

    {{-- Stock --}}
    <span class="qty">
        {{ $product->stock }} موجود
    </span>

    {{-- Price --}}
    <span class="price">

       @if($product->has_discount)

            <div class="d-flex justify-content-between align-items-center w-100">

                {{-- Original Price --}}
                <span
                    style="
                        color: #dc3545 !important;
                        font-size: 14px;
                        font-weight: 500;
                        text-decoration: line-through;
                        text-decoration-color: #dc3545;
                        text-decoration-thickness: 1px;
                    "
                >
                    {{ number_format($product->price) }} تومان
                </span>

                {{-- Discount Price --}}
                <span>
                    {{ number_format($product->discount_price) }} تومان
                </span>

            </div>

        @else

            {{ number_format($product->price) }} تومان

        @endif

    </span>

    {{-- Add To Cart --}}
    <x-client.product-qty :product="$product" :in-cart="$inCart" />

</div>

