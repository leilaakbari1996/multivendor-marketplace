@props([
    'id'   => 'alert',
    'type' => 'info',   // success | danger | warning | info
])

@php
    $flash = session($type === 'danger' ? 'error' : $type);
@endphp

<div
    id="{{ $id }}"
    role="alert"
    {{ $attributes->class(['alert', 'alert-' . $type, 'd-none' => !$flash]) }}
>{{ $flash }}</div>
