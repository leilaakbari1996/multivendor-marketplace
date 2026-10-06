<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title d-flex align-items-center gap-2 mb-0" id="offcanvasCartLabel">
            <span class="text-primary">سبد خرید</span>
            <span class="badge bg-primary rounded-pill" data-cart-count>{{ $cartCount }}</span>
        </h5>
        <button type="button" class="btn-close m-0" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
    </div>

    <div id="cartBody" class="d-flex flex-column flex-grow-1 overflow-y-auto">
        @include('client.partials.cart.cart-body')
    </div>
</div>
