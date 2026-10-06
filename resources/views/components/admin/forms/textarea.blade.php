{{-- resources/views/components/form/textarea.blade.php --}}

@props([
    'name',
    'label' => null,
    'value' => '',
    'rows' => 5,
    'cols' => 10,
    'placeholder' => null,
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control @error($name) is-invalid @enderror"
        cols="{{ $cols }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
    >{{ old($name, $value) }}</textarea>

    <x-admin.forms.error name="{{$name}}" />
</div>
