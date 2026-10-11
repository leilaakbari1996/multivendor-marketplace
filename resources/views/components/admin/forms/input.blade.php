@props([
    'name' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'id' => null,
    'placeholder' => null,
    'defaultClass' => true,
    'jdp' => false,
    'jdpTime' => false,
    'readonly' => false,
    'disabled' => false,
])

<div class="form-group">

    @if ($label)
        <label for="{{ $id ?? $name }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"

        @if($jdp) data-jdp @endif
        @if($jdpTime) data-jdp-time @endif
        @if($readonly) readonly @endif
        @if($disabled) disabled @endif

        {{ $attributes->class([
            'form-control' => $defaultClass,
            'is-invalid' => $errors->has($name),
        ]) }}
    >

    <x-admin.forms.error :name="$name" />

</div>
