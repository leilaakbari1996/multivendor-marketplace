@php
    use App\Constants\AdminView;
@endphp

@extends('admin.layouts.app')

@push('styles')
    @include('admin.assets.create_css')
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'دسترسی‌ها',
                'url' => route(AdminView::PERFIX_ROUTE . 'permission.index'),
            ],
        ]"
        current="ایجاد دسترسی"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'permission.store') }}"
        method="post"
    >
        @csrf

        <div class="row layout-top-spacing">

            {{-- اطلاعات دسترسی --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">اطلاعات دسترسی</h5>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="name"
                                id="permission-name"
                                label="نام فارسی"
                                placeholder="نام فارسی دسترسی"
                            />
                        </div>


                    </div>

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="description"
                                id="permission-description"
                                label="توضیحات"
                                placeholder="توضیحات دسترسی"
                                rows="6"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- تنظیمات دسترسی --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area">

                    <h5 class="mb-4">تنظیمات دسترسی</h5>

                    <div class="col-12 mb-4">

                        <x-admin.forms.input
                            name="slug"
                            id="permission-slug"
                            label="شناسه دسترسی products به صورت جمع باشد. (products.view) "
                            placeholder="مثلاً products.view"
                        />

                    </div>

                    <div class="col-12">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ایجاد دسترسی
                        </x-admin.forms.button>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('scripts')

    @include('admin.assets.create_js')

@endpush
