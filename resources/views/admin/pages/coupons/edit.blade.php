@use('App\Constants\AdminView')
@use('App\Enums\CouponType')
@use('App\Support\DateHelper')

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

    <link
        rel="stylesheet"
        href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css"
    >
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => __('coupon.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'coupon.index'),
            ],
        ]"
        :current="__('coupon.edit')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'coupon.update', $coupon) }}"
        method="post"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="code"
                                id="coupon-code"
                                :label="__('coupon.fields.code')"
                                :placeholder="__('coupon.placeholders.code')"
                                :value="old('code', $coupon->code)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.tom-select
                                name="type"
                                :label="__('coupon.fields.type')"
                                :options="CouponType::options()"
                                :value="old('type', $coupon->type->value)"
                                :placeholder="__('coupon.placeholders.type')"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="value"
                                type="number"
                                id="coupon-value"
                                :label="__('coupon.fields.value')"
                                :placeholder="__('coupon.placeholders.value')"
                                min="0"
                                step="0.01"
                                :value="old('value', $coupon->value)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="max_discount_amount"
                                type="number"
                                id="coupon-max-discount"
                                :label="__('coupon.fields.max_discount_amount')"
                                :placeholder="__('coupon.placeholders.max_discount_amount')"
                                min="0"
                                :value="old('max_discount_amount', $coupon->max_discount_amount)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="min_order_amount"
                                type="number"
                                id="coupon-min-order"
                                :label="__('coupon.fields.min_order_amount')"
                                :placeholder="__('coupon.placeholders.min_order_amount')"
                                min="0"
                                :value="old('min_order_amount', $coupon->min_order_amount)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="usage_limit"
                                type="number"
                                id="coupon-usage-limit"
                                :label="__('coupon.fields.usage_limit')"
                                :placeholder="__('coupon.placeholders.usage_limit')"
                                min="1"
                                :value="old('usage_limit', $coupon->usage_limit)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="starts_at"
                                type="text"
                                id="coupon-starts-at"
                                :label="__('coupon.fields.starts_at')"
                                :placeholder="__('coupon.placeholders.starts_at')"
                                :value="old(
                                    'starts_at',
                                    $coupon->starts_at
                                        ? DateHelper::toJalali($coupon->starts_at)
                                        : null
                                )"
                                jdp
                                data-jdp-time
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="expires_at"
                                type="text"
                                id="coupon-expires-at"
                                :label="__('coupon.fields.expires_at')"
                                :placeholder="__('coupon.placeholders.expires_at')"
                                :value="old(
                                    'expires_at',
                                    $coupon->expires_at
                                        ? DateHelper::toJalali($coupon->expires_at)
                                        : null
                                )"
                                jdp
                                data-jdp-time
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.switch
                            name="is_active"
                            id="coupon-is-active"
                            :label="__('coupon.fields.is_active')"
                            :checked="(bool) old('is_active', $coupon->is_active)"
                            value="1"
                        />
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <x-admin.forms.button
                            type="submit"
                            class="btn-primary w-100"
                        >
                            {{ __('coupon.update') }}
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
