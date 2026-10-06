
@props([
    'name' => 'body',
    'id' => 'blog-description',
    'label' => 'محتوا',
    'value' => '',
])

<div class="col-sm-12">

    <textarea
        name="{{ $name }}"
        id="input-{{ $id }}"
        style="display: none;"
    >{{ old($name, $value) }}</textarea>

    <label>{{ $label }}</label>

    <div id="{{ $id }}"></div>

</div>

<x-admin.forms.error name="{{ $name }}" />


