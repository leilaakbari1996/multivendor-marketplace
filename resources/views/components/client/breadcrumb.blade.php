@props([
    'items' => [],
    'current' => null,
])

@php
    $crumbs = collect($items)
        ->prepend(['title' => 'خانه', 'url' => url('/')])
        ->values();

    $schemaItems = $crumbs
        ->map(fn ($item, $i) => [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $item['title'],
            'item'     => $item['url'],
        ])
        ->when($current, fn ($c) => $c->push([
            '@type'    => 'ListItem',
            'position' => $c->count() + 1,
            'name'     => $current,
        ]))
        ->all();
@endphp

<nav class="breadcrumb-nav" aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($crumbs as $item)
            <li class="breadcrumb-item">
                <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
            </li>
        @endforeach

        @if($current)
            <li class="breadcrumb-item active" aria-current="page">{{ $current }}</li>
        @endif
    </ol>
</nav>

<script type="application/ld+json">
    {!! json_encode([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $schemaItems,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
</script>
