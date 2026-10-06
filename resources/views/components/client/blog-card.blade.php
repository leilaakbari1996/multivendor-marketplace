@props(['post'])
@php
use App\Support\DateHelper;
@endphp

<article class="post-item card border-0 shadow-sm p-3 h-100 product-item position-relative">
    <x-client.like-button
        type="post"
        :id="$post->id"
        :is-liked="$post->likes->isNotEmpty()"
    />
    <div class="image-holder zoom-effect">
        <a href="{{ route('blogs.show',$post->slug) }}">
            @if($post->image)
                <img
                    src="{{ $post->image->url }}"
                    alt="{{ $post->title }}"
                    class="card-img-top"
                >
            @endif
        </a>
    </div>

    <div class="card-body">
        <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">

            @if($post->published_at)
                <div class="meta-date">
                    <svg width="16" height="16">
                        <use xlink:href="#calendar"></use>
                    </svg>

                    {{ DateHelper::toJalali($post->published_at,'Y/m/d') }}
                </div>
            @endif

        </div>

        <div class="post-header">
            <h3 class="post-title">
                <a href="{{ route('blogs.show',$post->slug) }}" class="text-decoration-none">
                    {{ $post->title }}
                </a>
            </h3>

            @if($post->excerpt)
                <p>
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
    </div>

</article>
