@props([
    'name',
    'id' => null,
    'label' => null,
    'value' => '1',
    'checked' => false,
    'feedback' => null,
    'wrapperClass' => null,
])

@php
    $id = $id ?: $name;
    $hasError = $errors->has($name);
    // بعد از خطای اعتبارسنجی، چک‌باکس تیک‌نخورده در old() نیست؛ پس باید جدا بررسی شود
    $isChecked = count(old()) ? old($name) !== null : (bool) $checked;
    $message = $errors->first($name) ?: $feedback;
@endphp



    <label class="check" for="{{ $id }}">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($isChecked)
            {{ $attributes->class(['check-input', 'invalid' => $hasError]) }}
        >
        <span>{{ $label ?? $slot }}</span>
    </label>

    @if($hasError || $feedback)
        <div class="err {{ $hasError ? 'show' : '' }}">{{ $message }}</div>
    @endif


