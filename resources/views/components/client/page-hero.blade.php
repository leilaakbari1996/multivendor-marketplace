@props([
    'title',
    'description' => null,
    'icon'        => 'bi-headset',   // کلاس Bootstrap Icons؛ برای نداشتن آیکن: :icon="null"
    'iconColor'   => '#eda415',
    'crumbs'      => null,           // [['خانه', url('/')], ['تماس با ما']] ؛ آیتم آخر = صفحه فعلی
])

@php
    // پیش‌فرض: خانه / عنوان صفحه
    $crumbs = $crumbs ?? [['خانه', url('/')], [$title]];
@endphp

<div {{ $attributes->merge(['class' => 'container mt-4']) }}>
    <div class="card-soft p-4 p-md-5" style="background:linear-gradient(135deg,#fff8e6 0%,#fff 60%)">
        <div class="row align-items-center">

            <div class="col-md-7">
                <h2 class="fw-bold mb-2">{{ $title }}</h2>

                @if ($description)
                    <p class="text-muted mb-0">{{ $description }}</p>
                @endif

                {{-- محتوای اضافه (مثلاً دکمه) --}}
                {{ $slot }}

                <nav class="mt-3 small text-muted" aria-label="breadcrumb">
                    @foreach ($crumbs as $crumb)
                        @if ($loop->last)
                            <span class="text-dark fw-bold" aria-current="page">{{ $crumb[0] }}</span>
                        @else
                            <a href="{{ $crumb[1] ?? '#' }}" class="text-decoration-none text-muted">{{ $crumb[0] }}</a> /
                        @endif
                    @endforeach
                </nav>
            </div>

            @if ($icon)
                <div class="col-md-5 text-center mt-3 mt-md-0">
                    <i class="bi {{ $icon }}" style="font-size:90px;color:{{ $iconColor }}" aria-hidden="true"></i>
                </div>
            @endif

        </div>
    </div>
</div>
