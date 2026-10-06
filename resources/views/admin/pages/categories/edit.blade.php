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
        current="ویرایش دسته بندی"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'category.update', $category) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- Main Content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="name"
                                id="category-name"
                                placeholder="عنوان"
                                value="{{ old('name', $category->name) }}"
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
                            value="{{ old('sort_order', $category->sort_order) }}"
                        />
                    </div>

                    <div class="row mb-4">
                        <x-admin.forms.textarea
                            name="description"
                            label="توضیحات"
                            :value="old('description', $category->description)"
                        />
                    </div>

                </div>

                {{-- SEO --}}
                <div class="widget-content widget-content-area blog-create-section mt-4">

                    <h5 class="mb-4">تنظیمات سئو</h5>

                    <div class="row mb-4">

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="meta_title"
                                id="category-meta-title"
                                placeholder="عنوان متا"
                                value="{{ old('meta_title', $category->meta_title) }}"
                            />
                        </div>

                        <div class="col-xxl-12">
                            <x-admin.forms.textarea
                                name="meta_description"
                                label="توضیحات متا"
                                :value="old('meta_description', $category->meta_description)"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Status --}}
                    <div class="row">

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.switch
                                name="is_active"
                                label="فعال"
                                :checked="old('is_active', $category->is_active)"
                            />
                        </div>

                    </div>

                    {{-- Tags --}}
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="tags"
                            id="tags"
                            label="تگ ها"
                            :defaultClass="false"
                            class="blog-tags"
                            value="{{ old('tags', $category->tags->pluck('name')->implode(',')) }}"
                        />
                    </div>

                    {{-- Parent Category --}}
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="category"
                            :options="$categories->pluck('name', 'id')->toArray()"
                            :value="old('category')"
                            placeholder="انتخاب دسته بندی والد"
                            value="{{ old('category', $category->parent_id) }}"
                        />
                    </div>
                    {{-- Image --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.file-upload
                            name="image"
                            id="category-image"
                            label="تصویر دسته بندی"
                            :multiple="false"
                            :allowReorder="false"
                            :maxFiles="1"
                            :existingFile="$imageUrl"
                        />

                    </div>

                    {{-- Submit --}}
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            ویرایش دسته بندی
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
