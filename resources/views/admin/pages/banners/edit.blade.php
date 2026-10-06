@php
    use App\Constants\AdminView;
    use App\Enums\BannerPosition;
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
                'title' => 'بنرها',
                'url' => route(AdminView::PERFIX_ROUTE . 'banner.index'),
            ],
        ]"
        current="ویرایش بنر"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'banner.update', $banner) }}"
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
                                label="عنوان"
                                placeholder="عنوان بنر"
                                :value="old('title', $banner->title)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.input
                                name="subtitle"
                                id="subtitle"
                                label="عنوان فرعی"
                                placeholder="عنوان فرعی"
                                :value="old('subtitle', $banner->subtitle)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <x-admin.forms.textarea
                                name="description"
                                label="توضیحات"
                                placeholder="توضیحات بنر"
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
                                label="فعال"
                                :checked="old('is_active', $banner->is_active)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="url"
                                id="url"
                                label="آدرس"
                                placeholder="https://example.com"
                                :value="old('url', $banner->url)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.tom-select
                                name="position"
                                :options="collect(BannerPosition::cases())
                                    ->mapWithKeys(fn ($position) => [
                                        $position->value => $position->label()
                                    ])
                                    ->toArray()"
                                :value="old('position', $banner->position?->value)"
                                placeholder="انتخاب موقعیت بنر"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="sort_order"
                                type="number"
                                id="sort_order"
                                label="ترتیب نمایش"
                                placeholder="ترتیب نمایش"
                                :value="old('sort_order', $banner->sort_order)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">

                            @php
                                $image = $banner->media
                                    ->where('collection', \App\Enums\MediaCollection::IMAGE)
                                    ->first();

                                $imageUrl = $image
                                    ? app(\App\Services\LocalFileUploader::class)->url(
                                        path: $image->file_path,
                                        disk: $image->disk,
                                    )
                                    : null;
                            @endphp

                            <x-admin.forms.file-upload
                                name="image"
                                id="banner-image"
                                label="تصویر بنر"
                                :existingFile="$imageUrl"
                            />

                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                            <x-admin.forms.button
                                type="submit"
                                class="btn-success w-100"
                            >
                                بروزرسانی بنر
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
