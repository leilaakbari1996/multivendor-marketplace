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
                'title' => 'کاربران',
                'url' => route('panel.user.index'),
            ],
        ]"
        current="ایجاد کاربر"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'user.store') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="row layout-top-spacing">

            {{-- Main information --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">اطلاعات کاربر</h5>

                    <div class="row mb-4">

                        <div class="col-md-6 mb-4 mb-md-0">
                            <x-admin.forms.input
                                name="user_name"
                                id="user-name"
                                label="نام کاربری"
                                placeholder="نام کاربری"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="mobile"
                                id="mobile"
                                type="text"
                                label="شماره موبایل"
                                placeholder="شماره موبایل"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-md-6 mb-4 mb-md-0">
                            <x-admin.forms.input
                                name="password"
                                id="password"
                                type="password"
                                label="رمز عبور"
                                placeholder="رمز عبور"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="password_confirmation"
                                id="password-confirmation"
                                type="password"
                                label="تکرار رمز عبور"
                                placeholder="تکرار رمز عبور"
                            />
                        </div>

                    </div>

                </div>

                {{-- User roles --}}
{{--                <div class="widget-content widget-content-area mt-4 ">--}}

{{--                    <label class="form-label">--}}
{{--                        نقش‌ها--}}
{{--                    </label>--}}

{{--                    <div class="row">--}}

{{--                        @forelse($roles as $role)--}}

{{--                            <div class="col mb-2">--}}

{{--                                <x-admin.forms.checkbox--}}
{{--                                    name="roles[]"--}}
{{--                                    :id="'role-' . $role->id"--}}
{{--                                    :value="$role->id"--}}
{{--                                    :label="$role->name"--}}
{{--                                    :checked="in_array(--}}
{{--                                        $role->id,--}}
{{--                                        old('roles', [])--}}
{{--                                    )"--}}
{{--                                />--}}

{{--                            </div>--}}

{{--                        @empty--}}

{{--                            <div class="alert alert-warning mb-0">--}}
{{--                                هنوز هیچ نقشی ایجاد نشده است.--}}
{{--                            </div>--}}

{{--                        @endforelse--}}

{{--                    </div>--}}

{{--                </div>--}}

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">تنظیمات کاربر</h5>

                    {{-- User type --}}
                    <div class="col-12 mb-4">

                        <x-admin.forms.tom-select
                            name="type"
                            :options="$types"
                            :value="old('type', \App\Enums\UserType::CUSTOMER->value)"
                            placeholder="انتخاب نوع کاربر"
                        />

                    </div>

                    {{-- User status --}}
                    <div class="col-12 mb-4">

                        <x-admin.forms.tom-select
                            name="status"
                            :options="$statuses"
                            :value="old('status', \App\Enums\UserStatus::ACTIVE->value)"
                            placeholder="انتخاب وضعیت"
                        />

                    </div>


                    {{-- Profile image --}}
                    <div class="col-12 mb-4">

                        <x-admin.forms.file-upload
                            name="image"
                            id="user-image"
                            label="تصویر پروفایل"
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
                            ایجاد کاربر
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
