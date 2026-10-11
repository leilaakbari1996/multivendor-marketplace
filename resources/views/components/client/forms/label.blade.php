
@props([
    'for',
    'label',
    'optional' => false,
])

<label for="{{ $for }}" {{ $attributes->class(['form-label', 'fw-semibold']) }}>
    {{ $label }}

    @if($optional)
        <span style="color: #6c757d;">(اختیاری)</span>
    @else
        <span class="text-danger">(ضروری)</span>
    @endif
</label>

