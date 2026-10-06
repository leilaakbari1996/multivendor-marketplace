
@php
    use App\Constants\AdminView;
    use App\Support\DateHelper;

    $publishedAt = $post->published_at
        ? DateHelper::toJalali($post->published_at)
        : null;
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

    <link
        rel="stylesheet"
        href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css"
    >
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'مقالات',
                'url' => route(AdminView::PERFIX_ROUTE . 'post.index'),
            ],
        ]"
        current="ویرایش مقاله"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'post.update', $post) }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- Main content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Title --}}
                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.input
                                name="title"
                                id="post-title"
                                label="عنوان مقاله"
                                placeholder="عنوان مقاله"
                                :value="old('title', $post->title)"
                            />
                        </div>

                    </div>

                    {{-- Excerpt --}}
                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="excerpt"
                                label="خلاصه مقاله"
                                placeholder="خلاصه‌ای کوتاه از مقاله"
                                rows="4"
                                :value="old('excerpt', $post->excerpt)"
                            />
                        </div>

                    </div>

                    {{-- Content --}}
                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.content-editor
                                name="content"
                                id="blog-description"
                                label="محتوای مقاله"
                                placeholder="محتوای مقاله را وارد کنید..."
                                :value="old('content', $post->content)"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Status --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.tom-select
                            name="status"
                            label="وضعیت"
                            :options="$statuses"
                            :value="old('status', $post->status->value)"
                            placeholder="انتخاب وضعیت"
                        />

                    </div>

                    {{-- Featured --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <div class="form-check form-switch">

                            <input
                                type="hidden"
                                name="is_featured"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_featured"
                                id="post-is-featured"
                                value="1"
                                @checked(old('is_featured', $post->is_featured))
                            >

                            <label
                                class="form-check-label"
                                for="post-is-featured"
                            >
                                مقاله ویژه
                            </label>

                        </div>

                    </div>

                    {{-- Published at --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.input
                            name="published_at"
                            type="text"
                            id="post-published-at"
                            label="تاریخ انتشار"
                            :value="old('published_at', $publishedAt)"
                            jdp
                        />

                    </div>

                    {{-- Main image --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.file-upload
                            name="image"
                            id="post-image"
                            label="تصویر مقاله"
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
                            ویرایش مقاله
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

    @include('assets.js.jalalidatepicker')

@endpush

