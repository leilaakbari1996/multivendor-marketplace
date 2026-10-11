
<section class="py-5">
    <div class="container-fluid">
        <div class="row">

            @foreach($promoBanners as $banner)
                @php
                    $image = $banner->media
                        ->where('collection', \App\Enums\MediaCollection::IMAGE)
                        ->first();
                @endphp

                <div class="col-md-6">
                    <div
                        class="banner-ad mb-3 {{ $loop->first ? 'bg-danger' : 'bg-info' }}"
                        @if($image)
                            style="
                                background-image: url('{{$image->url }}');
                                background-repeat: no-repeat;
                                background-position: right bottom;
                            "
                        @endif
                    >
                        <div class="banner-content p-5">

                            @if($banner->subtitle)
                                <div class="categories text-primary fs-3 fw-bold">
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
                                    class="btn btn-dark text-uppercase w-auto"
                                >
                                    مشاهده
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

