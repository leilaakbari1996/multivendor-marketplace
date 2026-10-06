@props([
    'name',
    'id' => null,
    'label',
    'icon' => null,
    'checked' => false,
])

@php
    $id = $id ?: $name;
@endphp

<div class="form-check form-switch filter-switch">

    <input
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="1"
        class="form-check-input"
        role="switch"
        @checked($checked)
    >

    <label for="{{ $id }}" class="form-check-label fw-semibold">
        @if($icon)
            <i class="bi bi-{{ $icon }} me-1 text-muted"></i>
        @endif
        {{ $label }}
    </label>

</div>
