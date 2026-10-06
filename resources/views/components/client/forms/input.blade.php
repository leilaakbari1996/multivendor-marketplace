@props([
    'name',
    'id' => null,
    'label' => null,
    'icon' => null,
    'type' => 'text',
    'value' => null,
    'feedback' => null,
    'wrapperClass' => 'mb-3',
])

@php
    $id = $id ?: $name;
    $hasError = $errors->has($name);
    $inputValue = $type === 'password' ? null : old($name, $value);
@endphp

<div class="{{ $wrapperClass }}">

    @if($label)
        <label for="{{ $id }}" class="form-label fw-semibold">{{ $label }}</label>
    @endif

    <div class="position-relative">

        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            @if($inputValue !== null) value="{{ $inputValue }}" @endif
            {{ $attributes->merge([
                'class' => 'form-control rounded-3'
                    . ($icon ? ' pe-5' : '')
                    . ($hasError ? ' is-invalid' : ''),
            ]) }}
        >

        @if($icon)
            <iconify-icon
                icon="{{ $icon }}"
                class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
            ></iconify-icon>
        @endif

        {{-- باید هم‌سطح input باشد تا .is-invalid ~ .invalid-feedback و siblings() در JS کار کند --}}
        @if($feedback !== null)
            <div class="invalid-feedback">{{ $errors->first($name) ?: $feedback }}</div>
        @endif

    </div>

    @if($feedback === null)
        @error($name)
        <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    @endif

</div>
