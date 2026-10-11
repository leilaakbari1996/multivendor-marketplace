<section class="py-5">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex justify-content-between border-bottom mb-5">

                    <h2 class="section-title">
                        محصولات پرفروش
                    </h2>

                    <a
                        href="{{ route('products.index', ['is_best_selling' => 1]) }}"
                        class="btn-link text-decoration-none"
                    >
                        مشاهده همه محصولات پرفروش ←
                    </a>

                </div>

            </div>
        </div>

        <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-2xl-4 justify-content-start">

            @foreach($bestSellingProducts as $product)

                <div class="col">
                    <x-client.product-card :product="$product" />
                </div>

            @endforeach

        </div>

    </div>
</section>

