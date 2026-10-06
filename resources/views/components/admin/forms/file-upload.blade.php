@props([
    'name' => 'filepond',
    'id' => null,
    'label' => null,
    'maxFileSize' => '3MB',
    'existingFile' => null,
])

@php
    $inputId = $id ?? $name;
@endphp

@if($label)
    <label for="{{ $inputId }}">
        {{ $label }}
    </label>
@endif

<div class="multiple-file-upload">
    <input
        type="file"
        class="filepond file-upload-multiple"
        name="{{ $name }}"
        id="{{ $inputId }}"
        data-max-file-size="{{ $maxFileSize }}"
        data-max-files="1"
        @if($existingFile)
            data-existing-file="{{ $existingFile }}"
        @endif
    >
</div>

@error($name)
<div class="text-danger mt-2">
    {{ $message }}
</div>
@enderror

{{--@props([--}}
{{--    'name' => 'filepond',--}}
{{--    'id' => null,--}}
{{--    'label' => null,--}}
{{--    'multiple' => false,--}}
{{--    'maxFiles' => 1,--}}
{{--    'maxFileSize' => '3MB',--}}
{{--    'allowReorder' => false,--}}
{{--    'existingFile' => null,--}}
{{--    'existingFiles' => [],--}}
{{--])--}}

{{--@if($label)--}}
{{--    <label for="{{ $id ?? $name }}">--}}
{{--        {{ $label }}--}}
{{--    </label>--}}
{{--@endif--}}

{{--<div class="multiple-file-upload">--}}
{{--    <input--}}
{{--        type="file"--}}
{{--        class="filepond file-upload-multiple"--}}
{{--        name="{{ $name }}"--}}
{{--        id="{{ $id ?? $name }}"--}}
{{--        @if($multiple) multiple @endif--}}
{{--        data-allow-reorder="{{ $allowReorder ? 'true' : 'false' }}"--}}
{{--        data-max-file-size="{{ $maxFileSize }}"--}}
{{--        data-max-files="{{ $maxFiles }}"--}}
{{--        @if($existingFile)--}}
{{--            data-existing-file="{{ $existingFile }}"--}}
{{--        @endif--}}
{{--        @if($existingFiles)--}}
{{--            data-existing-files='@json($existingFiles)'--}}
{{--        @endif--}}
{{--    >--}}
{{--</div>--}}

{{--@php--}}
{{--    $fieldName = str_replace('[]', '', $name);--}}
{{--@endphp--}}

{{--@error($fieldName)--}}
{{--<div class="text-danger mt-2">--}}
{{--    {{ $message }}--}}
{{--</div>--}}
{{--@enderror--}}

{{--@foreach($errors->get($fieldName . '.*') as $messages)--}}
{{--    @foreach($messages as $message)--}}
{{--        <div class="text-danger mt-2">--}}
{{--            {{ $message }}--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--@endforeach--}}
