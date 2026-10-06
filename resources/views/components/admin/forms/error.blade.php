{{--@props(['name'])--}}

{{--@error($name)--}}
{{--<div class="invalid-feedback">{{ $message }}</div>--}}
{{--@enderror--}}
@props(['name'])

@error($name)
<div class="text-danger mt-1">
    {{ $message }}
</div>
@enderror
