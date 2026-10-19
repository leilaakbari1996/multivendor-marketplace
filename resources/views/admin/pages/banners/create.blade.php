@use('App\Constants\AdminView')
@use('App\Enums\BannerPosition')

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
                'title' => __('banner.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'banner.index'),
            ],
        ]"
        :current="__('banner.create')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'banner.store') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="row layout-top-spacing">
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="title"
                                id="banner-title"
                                :label="__('banner.fields.title')"
                                :placeholder="__('banner.placeholders.title')"
                                :value="old('title')"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="subtitle"
                                id="banner-subtitle"
                                :label="__('banner.fields.subtitle')"
                                :placeholder="__('banner.placeholders.subtitle')"
                                :value="old('subtitle')"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.textarea
                                name="description"
                                :label="__('banner.fields.description')"
                                :placeholder="__('banner.placeholders.description')"
                                :value="old('description')"
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
                                id="banner-is-active"
                                :label="__('common.active')"
                                :checked="(bool) old('is_active', true)"
                                value="1"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="url"
                                id="banner-url"
                                type="url"
                                :label="__('banner.fields.url')"
                                :placeholder="__('banner.placeholders.url')"
                                :value="old('url')"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.tom-select
                                name="position"
                                :label="__('banner.fields.position')"
                                :options="collect(BannerPosition::cases())
                                    ->mapWithKeys(fn (BannerPosition $position) => [
                                        $position->value => $position->label(),
                                    ])
                                    ->toArray()"
                                :value="old('position')"
                                :placeholder="__('banner.placeholders.position')"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="sort_order"
                                type="number"
                                id="banner-sort-order"
                                :label="__('banner.fields.sort_order')"
                                :placeholder="__('banner.placeholders.sort_order')"
                                :value="old('sort_order', 0)"
                                min="0"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.file-upload
                                name="image"
                                id="banner-image"
                                :label="__('banner.fields.image')"
                            />
                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                            <x-admin.forms.button
                                type="submit"
                                class="btn-success w-100"
                            >
                                {{ __('banner.create') }}
                            </x-admin.forms.button>
                        </div>
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
