@props([
    'type' => 'submit',
    'variant' => 'primary',
    'icon' => null,
    'loading' => false,
    'textColor' => 'white',
    'width'   => '100%',
    'background' => null
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "btn btn-{$variant} text-{$textColor} px-3 d-inline-flex align-items-center justify-content-center gap-2 ",
    ]) }}
    style="width: {{$width}} ; background: {{ $background }}"
>
    @if($icon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif

    {{ $slot }}
</button>
