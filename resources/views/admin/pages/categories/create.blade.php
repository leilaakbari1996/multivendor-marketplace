@use('App\Constants\AdminView')
@use('App\Enums\CategoryType')

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
                'title' => __('category.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'category.index'),
            ],
        ]"
        :current="__('category.create')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'category.store') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="row layout-top-spacing">

            {{-- Main Content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="name"
                                id="post-title"
                                :placeholder="__('category.fields.name')"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="sort_order"
                                type="number"
                                id="sort_order"
                                :label="__('category.fields.sort_order')"
                                :placeholder="__('category.fields.sort_order')"
                                :value="old('sort_order', 0)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.textarea
                                name="description"
                                :label="__('category.fields.description')"
                            />
                        </div>
                    </div>

                </div>

                <div class="widget-content widget-content-area blog-create-section mt-4">

                    <h5 class="mb-4">{{ __('category.seo_settings') }}</h5>

                    <div class="row mb-4">
                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="meta_title"
                                id="post-meta-title"
                                :placeholder="__('category.fields.meta_title')"
                            />
                        </div>

                        <div class="col-xxl-12">
                            <x-admin.forms.textarea
                                name="meta_description"
                                :label="__('category.fields.meta_description')"
                            />
                        </div>
                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row">
                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.switch
                                name="is_active"
                                :label="__('common.active')"
                                :checked="(bool) old('is_active', true)"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.switch
                                name="is_main"
                                :label="__('category.fields.is_main')"
                                :checked="(bool) old('is_main', false)"
                            />
                        </div>
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="tags"
                            id="tags"
                            :label="__('category.fields.tags')"
                            :defaultClass="false"
                            class="blog-tags"
                        />
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="category"
                            :options="$categories->pluck('name', 'id')->toArray()"
                            :value="old('category')"
                            :placeholder="__('category.placeholders.parent')"
                        />
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="type"
                            :options="CategoryType::options()"
                            :value="old('type')"
                            :placeholder="__('category.fields.type')"
                            :label="__('category.fields.type')"
                        />
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.file-upload
                            name="image"
                            id="product-image"
                            :label="__('category.fields.image')"
                        />
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            {{ __('category.create') }}
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
