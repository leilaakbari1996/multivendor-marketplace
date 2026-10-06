{{-- resources/views/components/admin/forms/button.blade.php --}}

@props([
    'type' => 'button',
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn']) }}
>
    {{ $slot }}
</button>
