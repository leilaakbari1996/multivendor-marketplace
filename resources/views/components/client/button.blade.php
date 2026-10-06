@props([
    'type' => 'submit',
    'variant' => 'primary',
    'icon' => null,
    'loading' => false,
    'textColor' => 'white',
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "btn btn-{$variant} text-{$textColor} px-4 d-inline-flex align-items-center justify-content-center gap-2 ",
    ]) }}
>
    @if($icon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif

    {{ $slot }}
</button>
