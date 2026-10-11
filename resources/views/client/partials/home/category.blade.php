<section class="py-5 overflow-hidden">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="section-header d-flex flex-wrap justify-content-between mb-5">

                    <h2 class="section-title">
                        دسته‌بندی‌ها
                    </h2>

                    <div class="d-flex align-items-center">

                        <div class="swiper-buttons d-flex gap-1">
{{--                            <button--}}
{{--                                class=" btn-yellow swiper-prev category-carousel-prev"--}}
{{--                                type="button"--}}
{{--                            >--}}
{{--                                ❮--}}
{{--                            </button>--}}

                            <x-client.button
                                type="submit"
                                variant="yellow"
                                class="btn-sm swiper-prev category-carousel-prev"
                                width="auto"
                                textColor="black"
                                background="#F1F1F1"
                            >
                                ❮
                            </x-client.button>

                            <x-client.button
                                type="submit"
                                variant="yellow"
                                textColor="black"
                                class="btn-sm swiper-next category-carousel-next "
                                width="auto"
                                background="#F1F1F1"
                            >
                                ❯
                            </x-client.button>

{{--                            <button--}}
{{--                                class="btn-yellow swiper-next category-carousel-next"--}}
{{--                                type="button"--}}
{{--                            >--}}
{{--                                ❯--}}
{{--                            </button>--}}
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
                                href="{{ route('products.index', ['category' => $category->slug]) }}"
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
