@props([
    'name',
    'label',
    'checked' => false,
    'value' => 1,
])
<div class="switch form-switch-custom switch-inline form-switch-primary">
    <input
        class="switch-input"
        type="checkbox"
        role="switch"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $checked))
    >

    <label class="switch-label" for="{{ $name }}">
        {{ $label }}
    </label>
</div>
