{{--@props([--}}
{{--    'name',--}}
{{--    'options' => [],--}}
{{--    'value' => null,--}}
{{--    'placeholder' => 'Select an option...',--}}
{{--    'id' => null,--}}
{{--])--}}

{{--<select--}}
{{--    class="select-beast"--}}
{{--    name="{{ $name }}"--}}
{{--    placeholder="{{ $placeholder }}"--}}
{{--    autocomplete="off"--}}
{{--    {{ $attributes }}--}}
{{-->--}}
{{--    <option value="">{{ $placeholder }}</option>--}}

{{--    @foreach($options as $optionValue => $optionLabel)--}}
{{--        <option--}}
{{--            value="{{ $optionValue }}"--}}
{{--            @selected((string) $value === (string) $optionValue)--}}
{{--        >--}}
{{--            {{ $optionLabel }}--}}
{{--        </option>--}}
{{--    @endforeach--}}
{{--</select>--}}

{{--<x-admin.forms.error name="{{$name}}" />--}}

@props([
    'name',
    'options' => [],
    'value' => null,
    'placeholder' => 'Select an option...',
    'id' => null,
    'label' => null,
])

@if($label)
    <label for="{{ $id ?? $name }}" class="form-label">
        {{ $label }}
    </label>
@endif

<select
    id="{{ $id ?? $name }}"
    class="select-beast"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    autocomplete="off"
    {{ $attributes }}
>
    <option value="">{{ $placeholder }}</option>

    @foreach($options as $optionValue => $optionLabel)
        <option
            value="{{ $optionValue }}"
            @selected((string) $value === (string) $optionValue)
        >
            {{ $optionLabel }}
        </option>
    @endforeach
</select>

<x-admin.forms.error :name="$name" />
