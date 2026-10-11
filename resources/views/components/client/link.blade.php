@props([
    'href'    => null,
    'link'    => true,
])


@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes
            ->class(['link' => $link])
             }}
    >{{ $slot }}</a>
@else
    <span {{ $attributes }}>{{ $slot }}</span>
@endif
