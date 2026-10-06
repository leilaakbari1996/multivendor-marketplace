<section class="py-5 overflow-hidden">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex flex-wrap justify-content-between mb-5">

                    <h2 class="section-title">
                        دسته‌بندی‌ها
                    </h2>

                    <div class="d-flex align-items-center">

                        <div class="swiper-buttons">
                            <button
                                class="swiper-prev category-carousel-prev btn btn-yellow"
                                type="button"
                            >
                                ❮
                            </button>

                            <button
                                class="swiper-next category-carousel-next btn btn-yellow"
                                type="button"
                            >
                                ❯
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="category-carousel swiper">

                    <div class="swiper-wrapper">

                        @foreach($categories as $category)

                            <a
                                href="#"
                                class="nav-link category-item swiper-slide"
                            >

                                @if($category->media)
                                    <img
                                        src="{{ $category->media->url }}"
                                        alt="{{ $category->name }}"
                                        width="120"
                                        height="120"
                                        style="width: 120px; height: 120px; object-fit: contain;"
                                    >
                                @endif

                                <h3 class="category-title">
                                    {{ $category->name }}
                                </h3>

                            </a>

                        @endforeach

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>
