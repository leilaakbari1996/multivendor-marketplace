@php
    use App\Constants\AdminView;
@endphp
@extends('admin.layouts.app')
@push('styles')
    @include('admin.assets.create_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/src/plugins/src/tomSelect/tom-select.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/src/plugins/css/dark/tomSelect/custom-tomSelect.css') }}">
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
        [
            'title' => 'دسته بندی ها',
            'url' => route('panel.category.index'),
        ],
    ]"
        current="ایجاد دسته بندی"
    />


    <form action="{{ route(AdminView::PERFIX_ROUTE.'category.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row layout-top-spacing">
          <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                        <div class="widget-content widget-content-area blog-create-section">

                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <x-admin.forms.input
                                        name="name"
                                        id="post-title"
                                        placeholder="عنوان"
                                    />
                                </div>
                            </div>

                            <div class="col-xxl-12 mb-4">
                                <x-admin.forms.input
                                    name="sort_order"
                                    type="number"
                                    id="sort_order"
                                    placeholder="ترتیب نمایش"
                                    label="ترتیب نمایش"
                                />
                            </div>

                            <div class="row mb-4">
{{--                                <x-admin.forms.content-editor--}}
{{--                                    label="محتوا"--}}
{{--                                    id="blog-description"--}}
{{--                                />--}}
                                <x-admin.forms.textarea
                                    name="description"
                                    label="توضیحات"
                                />
                            </div>
                        </div>

                        <div class="widget-content widget-content-area blog-create-section mt-4">

                            <h5 class="mb-4">تنظیمات سئو</h5>

                            <div class="row mb-4">
                                <div class="col-xxl-12 mb-4">
                                    <x-admin.forms.input
                                        name="meta_title"
                                        id="post-meta-title"
                                        placeholder="عنوان متا"
                                    />
                                </div>

                                <div class="col-xxl-12">
                                    <x-admin.forms.textarea
                                        name="meta_description"
                                        label="توضیحات متا"
                                    />
                                </div>
                            </div>

                        </div>

                    </div>

          <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">
                        <div class="widget-content widget-content-area blog-create-section">
                            <div class="row">
                                <div class="col-xxl-12 mb-4">
                                    <x-admin.forms.switch
                                        name="is_active"
                                        label="فعال"
                                        :checked="true"
                                    />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-md-12 mb-4">
                                <x-admin.forms.input
                                    name="tags"
                                    id="tags"
                                    label="تگ ها"
                                    :defaultClass="false"
                                    class="blog-tags"
                                />
                            </div>

                            <div class="col-xxl-12 col-md-12 mb-4">
                                <x-admin.forms.tom-select
                                    name="category"
                                    :options="$categories->pluck('name', 'id')->toArray()"
                                    :value="old('category')"
                                    placeholder="انتخاب دسته بندی والد"
                                />
                            </div>

                            <div class="col-xxl-12 col-md-12 mb-4">

                                <x-admin.forms.file-upload
                                    name="image"
                                    id="product-image"
                                    label="تصویر دسته‌بندی"
                                />

                            </div>

                            <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                                <x-admin.forms.button
                                    type="submit"
                                    class="btn-success w-100"
                                >
                                    ایجاد دسته بندی
                                </x-admin.forms.button>
                            </div>

                        </div>
                    </div>
        </div>
    </form>


@endsection

@push('scripts')
    <script>
        const categories = @json($categories);
    </script>
    <script src="{{ asset('admin/src/plugins/src/tomSelect/tom-select.base.js') }}"></script>

    @include('admin.assets.create_js')
@endpush
