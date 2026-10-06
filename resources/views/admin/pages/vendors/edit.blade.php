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
        current="ویرایش فروشنده"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'vendor.update', $vendor->id) }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- اطلاعات اصلی فروشنده --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">اطلاعات فروشنده</h5>

                    <div class="row mb-4">

                        <div class="col-md-6 mb-4 mb-md-0">
                            <x-admin.forms.input
                                name="store_name"
                                id="store-name"
                                label="نام فروشگاه"
                                placeholder="نام فروشگاه"
                                :value="old('store_name', $vendor->store_name)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="commission_rate"
                                id="commission-rate"
                                type="number"
                                label="درصد کمیسیون"
                                placeholder="درصد کمیسیون"
                                :value="old('commission_rate', $vendor->commission_rate)"
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
                                :value="old('url', $vendor->url)"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="national_code"
                                id="national-code"
                                label="کد ملی"
                                placeholder="کد ملی"
                                maxlength="10"
                                :value="old('national_code', $vendor->national_code)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="bio"
                                label="درباره فروشگاه"
                                placeholder="توضیح کوتاهی درباره فروشگاه"
                                :value="old('bio', $vendor->bio)"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- تنظیمات فروشنده --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">تنظیمات فروشنده</h5>

                    <div class="col-12 mb-4">
                        <x-admin.forms.tom-select
                            name="user_id"
                            :options="$users->mapWithKeys(fn ($user) => [
                                $user->id => $user->user_name
                                    ? $user->user_name
                                    : $user->mobile,
                            ])->toArray()"
                            :value="old('user_id', $vendor->user_id)"
                            placeholder="انتخاب کاربر"
                        />
                    </div>

                    <div class="col-12 mb-4">
                        <x-admin.forms.tom-select
                            name="status"
                            :options="$statuses"
                            :value="old('status', $vendor->status->value)"
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
                            :existingFile="$logoUrl"
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
                            :existingFile="$bannerUrl"
                        />

                    </div>

                    <div class="col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ویرایش فروشنده
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

@endpush
