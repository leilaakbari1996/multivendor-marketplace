@props([
    'href' => '#',
    'variant' => 'primary',
    'icon' => null,
    'textColor' => 'white',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => "btn btn-{$variant} text-{$textColor} px-4 d-inline-flex align-items-center justify-content-center gap-2",
    ]) }}
>
    @if($icon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif

    {{ $slot }}
</a>
