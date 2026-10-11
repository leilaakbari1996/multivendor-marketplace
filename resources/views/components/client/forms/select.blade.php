@props([
    'name',
    'id' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'feedback' => null,
    'wrapperClass' => '',
    'optional' => false
])

@php
    $id = $id ?: $name;
    $selected = old($name, $selected);
    $hasError = $errors->has($name);

    $selectedText = $placeholder ?? 'انتخاب کنید';
    foreach($options as $value => $text){
        if((string)$selected === (string)$value){
            $selectedText = $text;
            break;
        }
    }
@endphp

<div class="{{ $wrapperClass }}">
    @if($label)
        <x-client.forms.label :for="$id" :label="$label" :optional="$optional" />
    @endif

    <div class="custom-select {{ $hasError ? 'has-error' : '' }}" data-custom-select>
        <button type="button" class="select-btn" id="{{ $id }}_btn" aria-haspopup="listbox">
            <span class="select-text">{{ $selectedText }}</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>

        <ul class="select-list" role="listbox">
            @if($placeholder)
                <li data-value="" class="{{ $selected == '' ? 'active' : '' }}">{{ $placeholder }}</li>
            @endif
            @foreach($options as $value => $text)
                <li data-value="{{ $value }}" class="{{ (string)$selected === (string)$value ? 'active' : '' }}">{{ $text }}</li>
            @endforeach
        </ul>

        <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}" {{ $attributes }} />
    </div>

    @if($feedback !== null)
        <div class="invalid-feedback d-block">{{ $errors->first($name) ?: $feedback }}</div>
    @elseif($hasError)
        <small class="text-danger d-block mt-1">{{ $errors->first($name) }}</small>
    @endif
</div>
