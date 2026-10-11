@props([
    'value',                          // عدد خام، بدون جداکننده: 5000
    'label',
    'suffix'       => '',             // مثال: +
    'wrapperClass' => 'col-6 col-lg-3',
])

@php
    // مقدار اولیه با ارقام فارسی (قبل از اجرای شمارنده JS و برای SEO)
    $display = strtr(number_format((int) $value), [
        '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
        '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹', ',' => '٬',
    ]) . $suffix;
@endphp

<div class="{{ $wrapperClass }}">
    <div {{ $attributes->class(['card-box', 'p-3', 'p-md-4', 'text-center', 'h-100']) }}>
        <div class="stat-num" data-count="{{ (int) $value }}" data-suffix="{{ $suffix }}">{{ $display }}</div>
        <div class="small text-muted">{{ $label }}</div>
    </div>
</div>
