@props([
    'name',
    'label',
    'value' => 1,
    'id' => null,
    'checked' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<div class="form-check">
    <input
        class="form-check-input"
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        id="{{ $inputId }}"
        @checked(old($name, $checked))
    >

    <label
        class="form-check-label"
        for="{{ $inputId }}"
    >
        {{ $label }}
    </label>
</div>
