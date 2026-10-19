@use('App\Constants\AdminView')
@use('App\Enums\CategoryType')

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
                'title' => __('category.title'),
                'url' => route('panel.category.index'),
            ],
        ]"
        :current="__('category.edit')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'category.update', $category) }}"
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
                                :placeholder="__('category.fields.name')"
                                value="{{ old('name', $category->name) }}"
                            />
                        </div>
                    </div>

                    <div class="col-xxl-12 mb-4">
                        <x-admin.forms.input
                            name="sort_order"
                            type="number"
                            id="sort_order"
                            :placeholder="__('category.fields.sort_order')"
                            :label="__('category.fields.sort_order')"
                            value="{{ old('sort_order', $category->sort_order) }}"
                        />
                    </div>

                    <div class="row mb-4">
                        <x-admin.forms.textarea
                            name="description"
                            :label="__('category.fields.description')"
                            :value="old('description', $category->description)"
                        />
                    </div>

                </div>

                {{-- SEO --}}
                <div class="widget-content widget-content-area blog-create-section mt-4">

                    <h5 class="mb-4">{{ __('category.seo_settings') }}</h5>

                    <div class="row mb-4">

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="meta_title"
                                id="category-meta-title"
                                :placeholder="__('category.fields.meta_title')"
                                value="{{ old('meta_title', $category->meta_title) }}"
                            />
                        </div>

                        <div class="col-xxl-12">
                            <x-admin.forms.textarea
                                name="meta_description"
                                :label="__('category.fields.meta_description')"
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
                                :label="__('common.active')"
                                :checked="old('is_active', $category->is_active)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.switch
                                name="is_main"
                                :label="__('category.fields.is_main')"
                                :checked="old('is_main', $category->is_main)"
                            />
                        </div>

                    </div>

                    {{-- Tags --}}
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="tags"
                            id="tags"
                            :label="__('category.fields.tags')"
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
                            :placeholder="__('category.placeholders.parent')"
                            value="{{ old('category', $category->parent_id) }}"
                        />
                    </div>
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="type"
                            :options="CategoryType::options()"
                            value="{{ old('type', $category->type) }}"
                            :placeholder="__('category.fields.type')"
                            :label="__('category.fields.type')"
                        />
                    </div>

                    {{-- Image --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.file-upload
                            name="image"
                            id="category-image"
                            :label="__('category.fields.image')"
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
                            {{ __('category.edit') }}
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
