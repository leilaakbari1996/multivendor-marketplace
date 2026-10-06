@props([
    'name',
    'id' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'feedback' => null,
    'wrapperClass' => 'mb-4',
])

@php
    $id = $id ?: $name;
    $hasError = $errors->has($name);
@endphp

<div class="{{ $wrapperClass }}">

    @if($label)
        <label for="{{ $id }}" class="form-label fw-semibold">{{ $label }}</label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'form-select rounded-3' . ($hasError ? ' is-invalid' : ''),
        ]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @if($feedback !== null)
        <div class="invalid-feedback">{{ $errors->first($name) ?: $feedback }}</div>
    @elseif($hasError)
        <small class="text-danger d-block mt-1">{{ $errors->first($name) }}</small>
    @endif

</div>
