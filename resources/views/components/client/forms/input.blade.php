@props([
    'name',
    'id' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'feedback' => null,
    'wrapperClass' => null,
    'optional' => false
])

@php
    $id = $id ?: $name;
    $hasError = $errors->has($name);
    $inputValue = $type === 'password' ? null : old($name, $value);
    $message = $errors->first($name) ?: $feedback;
@endphp

<div class="field {{ $wrapperClass }}">

    @if($label)
        <x-client.forms.label
            :for="$id"
            :label="$label"
            :optional="$optional"
        />
    @endif

    @if($type === 'password')
        <div class="input has-eye">
    @endif

            <input
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                @if($inputValue !== null) value="{{ $inputValue }}" @endif
                {{ $attributes->class(['invalid' => $hasError]) }}
            >

            @if($type === 'password')
                <button type="button" class="eye" aria-label="نمایش رمز">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
        </div>
    @endif

    {{ $slot }}

    <div class="err {{ $hasError ? 'show' : '' }}">{{ $hasError ? $message : $feedback }}</div>

</div>
