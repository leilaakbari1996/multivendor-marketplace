@props([
    'settings' => [],
    'socials' => [],
    'wrapperClass' => 'd-flex gap-2',
])

@php
    $socials  = \App\Settings\SiteSettings::socials();
@endphp
<div class="{{ $wrapperClass }}">
    @foreach($socials as $key => $social)
        @if(!empty($settings[$key] ?? null))
            <a href="{{ $settings[$key] }}"
               target="_blank"
               rel="noopener"
               title="{{ $social['label'] }}"
               aria-label="{{ $social['label'] }}"
               class="icon-circle">
                <i class="bi {{ $social['icon'] }}"></i>
            </a>
        @endif
    @endforeach
</div>
