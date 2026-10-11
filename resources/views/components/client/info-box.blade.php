@props([
'icon',                          // مثال: bi-telephone
'title',
'value'        => null,          // متن اصلی
'href'         => null,          // اگر بدهی، value لینک می‌شود
'tel'          => null,          // میانبر: لینک tel: + چپ‌به‌راست
'mail'         => null,          // میانبر: لینک mailto: + چپ‌به‌راست
'ltr'          => false,         // dir="ltr" برای value
'note'         => null,          // متن کوچک زیر value
'wrapperClass' => 'col-md-3 col-sm-6',
])

@php
if ($tel) {
$value ??= $tel;
$href    = 'tel:' . preg_replace('/\s+/', '', $tel);
$ltr     = true;
} elseif ($mail) {
$value ??= $mail;
$href    = 'mailto:' . $mail;
$ltr     = true;
}
@endphp

<div class="{{ $wrapperClass }}">
    <div {{ $attributes->class(['info-box']) }}>

        <div class="info-icon">
            <i class="bi {{ $icon }}" aria-hidden="true"></i>
        </div>

        <h6 class="fw-bold">{{ $title }}</h6>

        @if (filled($value))
        @if ($href)
        <a href="{{ $href }}" @if ($ltr) dir="ltr" @endif class="text-muted small">{{ $value }}</a>
        @else
        <div class="text-muted small" @if ($ltr) dir="ltr" @endif>{{ $value }}</div>
        @endif
        @endif

        @if (filled($note))
        <div class="text-muted small">{{ $note }}</div>
        @endif

        {{-- محتوای دلخواه (مثلاً آیکن‌های شبکه اجتماعی) --}}
        {{ $slot }}
    </div>
</div>
