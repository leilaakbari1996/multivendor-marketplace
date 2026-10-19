@use('App\Constants\AdminView')
@use('App\Enums\BannerPosition')
@use('App\Enums\MediaCollection')

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
        :current="__('banner.edit')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'banner.update', $banner) }}"
        method="post"
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
                                name="title"
                                id="title"
                                :label="__('banner.fields.title')"
                                :placeholder="__('banner.placeholders.title')"
                                :value="old('title', $banner->title)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="subtitle"
                                id="subtitle"
                                :label="__('banner.fields.subtitle')"
                                :placeholder="__('banner.placeholders.subtitle')"
                                :value="old('subtitle', $banner->subtitle)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.textarea
                                name="description"
                                :label="__('banner.fields.description')"
                                :placeholder="__('banner.placeholders.description')"
                                :value="old('description', $banner->description)"
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
                                :checked="(bool) old('is_active', $banner->is_active)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="url"
                                id="url"
                                :label="__('banner.fields.url')"
                                placeholder="https://example.com"
                                :value="old('url', $banner->url)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.tom-select
                                name="position"
                                :options="BannerPosition::options()"
                                :value="old('position', $banner->position?->value)"
                                :placeholder="__('banner.placeholders.position')"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="sort_order"
                                type="number"
                                id="sort_order"
                                :label="__('banner.fields.sort_order')"
                                :placeholder="__('banner.fields.sort_order')"
                                :value="old('sort_order', $banner->sort_order)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.file-upload
                                name="image"
                                id="banner-image"
                                :label="__('banner.fields.image')"
                                :existingFile="$banner->getFirstMediaUrl(MediaCollection::IMAGE) ?: null"
                            />
                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                            <x-admin.forms.button
                                type="submit"
                                class="btn-success w-100"
                            >
                                {{ __('banner.update') }}
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
