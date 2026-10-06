@php
    use App\Constants\AdminView;
    use App\Enums\CouponType;
@endphp

@extends('admin.layouts.app')

@push('styles')
    @include('admin.assets.create_css')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/src/tomSelect/tom-select.default.min.css') }}"
    >

    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}"
    >
    <link rel="stylesheet" href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'کدهای تخفیف',
                'url' => route('panel.coupon.index'),
            ],
        ]"
        current="ایجاد کد تخفیف"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'coupon.store') }}"
        method="post"
    >
        @csrf

        <div class="row layout-top-spacing">

            {{-- Main content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Code --}}
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="code"
                                id="coupon-code"
                                label="کد تخفیف"
                                placeholder="مثلاً WELCOME10"
                                :value="old('code')"
                            />

                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">

                            <x-admin.forms.tom-select
                                name="type"
                                label="نوع تخفیف"
                                :options="CouponType::options()"
                                :value="old('type', CouponType::PERCENTAGE->value)"
                                placeholder="انتخاب نوع تخفیف"
                            />

                        </div>

                    </div>

                    {{-- Value --}}
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="value"
                                type="number"
                                id="coupon-value"
                                label="مقدار تخفیف"
                                placeholder="مقدار تخفیف"
                                min="0"
                                step="0.01"
                                :value="old('value')"
                            />

                        </div>

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="max_discount_amount"
                                type="number"
                                id="coupon-max-discount"
                                label="حداکثر مبلغ تخفیف"
                                placeholder="مثلاً 500000"
                                min="0"
                                :value="old('max_discount_amount')"
                            />

                        </div>

                    </div>

                    {{-- Minimum order --}}
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="min_order_amount"
                                type="number"
                                id="coupon-min-order"
                                label="حداقل مبلغ سفارش"
                                placeholder="مثلاً 1000000"
                                min="0"
                                :value="old('min_order_amount')"
                            />

                        </div>

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="usage_limit"
                                type="number"
                                id="coupon-usage-limit"
                                label="محدودیت استفاده"
                                placeholder="خالی = نامحدود"
                                min="1"
                                :value="old('usage_limit')"
                            />

                        </div>

                    </div>

                    {{-- Dates --}}
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="starts_at"
                                type="text"
                                id="coupon-starts-at"
                                label="شروع اعتبار"
                                :value="old('starts_at')"
                                placeholder="انتخاب تاریخ و زمان"
                                jdp
                                data-jdp-time
                            />

                        </div>

                        <div class="col-md-6">

                            <x-admin.forms.input
                                name="expires_at"
                                type="text"
                                id="coupon-expires-at"
                                label="پایان اعتبار"
                                placeholder="انتخاب تاریخ و زمان"
                                :value="old('expires_at')"
                                jdp
                                data-jdp-time
                            />

                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Status --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.switch
                            name="is_active"
                            id="coupon-is-active"
                            label="فعال"
                            :checked="old('is_active', true)"
                            value="1"
                        />

                    </div>

                    {{-- Submit --}}
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ایجاد کد تخفیف
                        </x-admin.forms.button>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('scripts')
    <script src="{{ asset('admin/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    @include('admin.assets.create_js')
    @include('assets.js.jalalidatepicker')
@endpush
