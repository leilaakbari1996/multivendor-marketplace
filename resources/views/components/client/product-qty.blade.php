@props(['product', 'inCart' => 0])

<div class="pd-buy"
     style="width: 100%"
>
    <div class="pd-qty product-qty">
        <button type="button"
                class="qty-plus quantity-right-plus btn-number"
                data-type="plus"
                aria-label="افزایش"
            @disabled($inCart >= $product->stock)>+</button>

        <input type="text"
               name="quantity"
               class="qty-input input-number"
               value="{{ $inCart }}"
               min="0"
               max="{{ $product->stock }}"
               readonly
               aria-label="تعداد">

        <button type="button"
                class="qty-minus quantity-left-minus btn-number"
                data-type="minus"
                aria-label="کاهش"
            @disabled($inCart <= 0)>−</button>
    </div>

    <button type="button"
            class="btn-cart add-cart"
            data-cart
            data-product-id="{{ $product->id }}">
        <i class="bi bi-bag-plus"></i>
        <span>افزودن به سبد</span>
    </button>
</div>
