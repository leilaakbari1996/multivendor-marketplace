@extends('client.layouts.app')

@section('title', 'ارتباط با ما')


@push('styles')
        <link rel="stylesheet" href="{{ asset('client/custom/css/contact.css') }}">
@endpush

@section('content')

<x-client.page-hero
    title=" {{$settings['contact_hero_title'] ?? 'تماس با ما' }}"
    description="{{ $settings['contact_hero_description'] ?? 'خوشحال می‌شویم صدای شما را بشنویم! برای پشتیبانی سفارش، همکاری و هر سوالی فرم زیر را پر کنید یا با راه‌های ارتباطی تماس بگیرید.' }}" />

<!-- باکس های اطلاعات -->
<div class="container mt-4">

    <div class="row g-3 justify-content-center">
        @foreach ($contactBoxes as $box)
            <x-client.info-box
                :icon="$box['icon']"
                :title="$box['title']"
                :tel="$box['tel'] ?? null"
                :mail="$box['mail'] ?? null"
                :value="$box['value'] ?? null"
                :note="$box['note'] ?? null" />
        @endforeach

        <x-client.info-box icon="bi-chat-dots" title="شبکه‌های اجتماعی">
            <x-client.social-links :settings="$settings"
                                   wrapperClass="d-flex justify-content-center gap-2 mt-2" />
        </x-client.info-box>
    </div>

</div>


<!-- فرم + نقشه -->
<div class="container mt-4">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card-soft p-4 p-md-5 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">ارسال پیام به فودمارت</h5>
                    <span class="badge rounded-pill" style="background:#fff4d6;color:#b87a00">پاسخ سریع</span>
                </div>
                <x-client.alert id="contact-alert" />

                <p class="text-muted small mb-4">فرم زیر را تکمیل کنید، کارشناسان ما در اسرع وقت با شما در ارتباط خواهند بود.</p>
                <form id="contact-form" method="POST" action="{{ route('contact.store') }}" novalidate>
                    @csrf

                    {{-- honeypot: کاربر واقعی نمی‌بیند؛ ربات‌ها پر می‌کنند --}}
                    <div class="visually-hidden" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-client.forms.input
                                name="name"
                                id="c-name"
                                label="نام و نام خانوادگی"
                                class=""
                                required
                            />
                        </div>

                        <div class="col-md-6">
                            <x-client.forms.input
                                name="phone"
                                id="c-phone"
                                label="شماره موبایل"
                                type="tel"
                                :value="auth()->user()->phone ?? ''"
                                placeholder="09xxxxxxxxx"
                                inputmode="numeric"
                                dir="ltr"
                                class=" text-end"
                                required
                            />
                        </div>

                        <div class="col-md-6">
                            <x-client.forms.input
                                name="email"
                                id="c-email"
                                :optional="true"
                                label='ایمیل'
                                type="email"
                                dir="ltr"
                                :value="old('email')"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-client.forms.select
                                name="subject"
                                id="c-subject"
                                label="موضوع"
                                :options="$subjects"
                                placeholder="انتخاب کنید"
                                required
                            />
                        </div>

                        <div class="col-12">
                            <x-client.forms.textarea
                                name="message"
                                id="c-message"
                                label="پیام شما"
                                rows="5"
                                maxlength="1000"
                                required
                            />
                        </div>
                    </div>

                    <x-client.button type="submit" variant="brand" width="100%" background="var(--amber)" class="px-5 mt-3">
                        ارسال پیام
                    </x-client.button>
                </form>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="map-box h-100">
                @if(!empty($settings['contact_map_embed'] ?? null))
                    {!! $settings['contact_map_embed'] !!}
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted small" style="min-height:420px">
                        نقشه هنوز تنظیم نشده است
                    </div>
                @endif
                <div style="position:absolute;bottom:15px;right:15px;left:15px;background:#fff;border-radius:14px;padding:14px 16px;box-shadow:0 8px 25px rgba(0,0,0,.1)" class="d-flex gap-3 align-items-center">
                    <div class="info-icon mb-0" style="width:44px;height:44px;font-size:20px;flex-shrink:0"><i class="bi bi-shop"></i></div>
                    <div><div class="fw-bold small">{{ $settings['site_name'] ?? '' }}</div><div class="text-muted small">{{ $settings['contact_address'] ?? '' }} — {{ $settings['contact_hours'] ?? '' }}</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('client/custom/js/contact') }}"></script>
@endpush
