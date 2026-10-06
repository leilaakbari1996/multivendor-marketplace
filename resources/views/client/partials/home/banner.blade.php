<section
    class="py-3"
    style="
        background-image: url('{{ asset('client/images/background-pattern.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
    "
>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="banner-blocks">

                    {{-- Main Banners --}}
                    <div class="banner-ad large bg-info block-1">

                        <div class="swiper main-swiper">

                            <div class="swiper-wrapper">

                                @foreach($banners['main'] as $banner)

                                    @php
                                        $image = $banner->media->first();
                                    @endphp

                                    <div class="swiper-slide">

                                        <div class="row banner-content p-5">

                                            <div class="content-wrapper col-md-7">

                                                @if($banner->subtitle)
                                                    <div class="categories mb-3 pb-3">
                                                        {{ $banner->subtitle }}
                                                    </div>
                                                @endif

                                                <h3 class="banner-title">
                                                    {{ $banner->title }}
                                                </h3>

                                                @if($banner->description)
                                                    <p>
                                                        {{ $banner->description }}
                                                    </p>
                                                @endif

                                                @if($banner->url)
                                                    <a
                                                        href="{{ $banner->url }}"
                                                        class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3"
                                                    >
                                                        مشاهده محصولات
                                                    </a>
                                                @endif

                                            </div>

                                            @if($image)
                                                <div class="img-wrapper col-md-5">
                                                    <img
                                                        src="{{ $image->url }}"
                                                        class="img-fluid"
                                                        alt="{{ $banner->title }}"
                                                    >
                                                </div>
                                            @endif

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                            <div class="swiper-pagination"></div>

                        </div>
                    </div>


                    {{-- Side Top Banner --}}
                    @if($banners['side_top'])

                        @php
                            $banner = $banners['side_top'];
                            $image = $banner->media->first();
                        @endphp

                        <div
                            class="banner-ad bg-success-subtle block-2"
                            @if($image)
                                style="
                                    background-image: url('{{ Storage::disk($image->disk)->url($image->file_path) }}');
                                    background-repeat: no-repeat;
                                    background-position: left bottom;
                                "
                            @endif
                        >

                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">

                                    @if($banner->subtitle)
                                        <div class="categories sale mb-3 pb-3">
                                            {{ $banner->subtitle }}
                                        </div>
                                    @endif

                                    <h3 class="banner-title">
                                        {{ $banner->title }}
                                    </h3>

                                    @if($banner->url)
                                        <a
                                            href="{{ $banner->url }}"
                                            class="d-flex align-items-center nav-link"
                                        >
                                            مشاهده محصولات

                                            <svg width="24" height="24">
                                                <use xlink:href="#arrow-left"></use>
                                            </svg>
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- Side Bottom Banner --}}
                    @if($banners['side_bottom'])

                        @php
                            $banner = $banners['side_bottom'];
                            $image = $banner->media->first();
                        @endphp

                        <div
                            class="banner-ad bg-danger block-3"
                            @if($image)
                                style="
                                    background-image: url('{{ Storage::disk($image->disk)->url($image->file_path) }}');
                                    background-repeat: no-repeat;
                                    background-position: left bottom;
                                "
                            @endif
                        >

                            <div class="row banner-content p-5">

                                <div class="content-wrapper col-md-7">

                                    @if($banner->subtitle)
                                        <div class="categories sale mb-3 pb-3">
                                            {{ $banner->subtitle }}
                                        </div>
                                    @endif

                                    <h3 class="item-title">
                                        {{ $banner->title }}
                                    </h3>

                                    @if($banner->url)
                                        <a
                                            href="{{ $banner->url }}"
                                            class="d-flex align-items-center nav-link"
                                        >
                                            مشاهده محصولات

                                            <svg width="24" height="24">
                                                <use xlink:href="#arrow-left"></use>
                                            </svg>
                                        </a>
                                    @endif

                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </div>
        </div>
    </div>
</section>
