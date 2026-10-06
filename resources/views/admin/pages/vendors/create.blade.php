@php
    use App\Constants\AdminView;
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
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'فروشندگان',
                'url' => route('panel.vendor.index'),
            ],
        ]"
        current="ایجاد فروشنده"
    />

    @if($users->isEmpty())

        <div class="alert alert-warning mb-0 mt-4">
            هنوز کاربری برای ایجاد فروشنده وجود ندارد.
        </div>

    @else
    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'vendor.store') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="row layout-top-spacing">

            {{-- اطلاعات اصلی فروشنده --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">اطلاعات فروشنده</h5>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="store_name"
                                id="store-name"
                                label="نام فروشگاه"
                                placeholder="نام فروشگاه"
                            />
                        </div>

                        <div class="col-6 mb-4">
                            <x-admin.forms.input
                                name="commission_rate"
                                id="commission-rate"
                                type="number"
                                label="درصد کمیسیون"
                                placeholder="درصد کمیسیون"
                                value="{{ old('commission_rate', 10) }}"
                                step="0.01"
                                min="0"
                                max="100"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6 mb-4 mb-md-0">
                            <x-admin.forms.input
                                name="url"
                                id="url"
                                label="آدرس فروشگاه"
                                placeholder="آدرس فروشگاه"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="national_code"
                                id="national-code"
                                label="کد ملی"
                                placeholder="کد ملی"
                                maxlength="10"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="bio"
                                label="درباره فروشگاه"
                                placeholder="توضیح کوتاهی درباره فروشگاه"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- تنظیمات فروشنده --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">تنظیمات فروشنده</h5>

                    <div class="col-md-12 mb-4">
{{--                        <x-admin.forms.tom-select--}}
{{--                            name="user_id"--}}
{{--                            :options="$users->pluck('user_name', 'id')->toArray()"--}}
{{--                            :value="old('user_id')"--}}
{{--                            placeholder="انتخاب کاربر"--}}
{{--                        />--}}
                        <x-admin.forms.tom-select
                            name="user_id"
                            :options="$users->pluck('user_name', 'id')->toArray()"
                            :value="old('user_id')"
                            placeholder="انتخاب کاربر"
                        />
                    </div>

                    <div class="col-12 mb-4">
                        <x-admin.forms.tom-select
                            name="status"
                            :options="$statuses"
                            :value="old('status', \App\Enums\VendorStatus::PENDING->value)"
                            placeholder="انتخاب وضعیت"
                        />
                    </div>

                    <div class="col-12 mb-4">

                        <x-admin.forms.file-upload
                            name="logo"
                            id="vendor-logo"
                            label="لوگوی فروشگاه"
                            :multiple="false"
                            :allowReorder="false"
                            :maxFiles="1"
                        />

                    </div>

                    <div class="col-12 mb-4">

                        <x-admin.forms.file-upload
                            name="banner"
                            id="vendor-banner"
                            label="بنر فروشگاه"
                            :multiple="false"
                            :allowReorder="false"
                            :maxFiles="1"
                        />

                    </div>

                    <div class="col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ایجاد فروشنده
                        </x-admin.forms.button>

                    </div>

                </div>

            </div>

        </div>
    </form>
    @endif

@endsection

@push('scripts')

    <script src="{{ asset('admin/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    @include('admin.assets.create_js')

@endpush
