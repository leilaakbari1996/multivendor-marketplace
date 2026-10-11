@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => null,
    'rows' => 3,
    'feedback' => null,
    'wrapperClass' => 'mb-3',
    'optional' => false
])

@php
    $id = $id ?: $name;
    $hasError = $errors->has($name);
    $textValue = old($name, $value);
@endphp

<div class="{{ $wrapperClass }}">

    @if($label)
        <x-client.forms.label
            :for="$id"
            :label="$label"
            :optional="$optional"
        />
    @endif

    {{-- محتوای textarea نباید فاصله یا خط اضافه داشته باشد --}}
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'rounded-3' . ($hasError ? ' is-invalid' : ''),
        ]) }}
    >{{ $textValue }}</textarea>

    @if($feedback !== null)
        <div class="invalid-feedback">{{ $errors->first($name) ?: $feedback }}</div>
    @elseif($hasError)
        <small class="text-danger d-block mt-1">{{ $errors->first($name) }}</small>
    @endif

</div>
