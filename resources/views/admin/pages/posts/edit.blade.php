@use('App\Constants\AdminView')
@use('App\Support\DateHelper')

@php
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
                'title' => __('post.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'post.index'),
            ],
        ]"
        :current="__('post.edit')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'post.update', $post) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="row mb-4">
                        <div class="col-12">
                            <x-admin.forms.input
                                name="title"
                                id="post-title"
                                :label="__('post.fields.title')"
                                :placeholder="__('post.placeholders.title')"
                                :value="old('title', $post->title)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="excerpt"
                                :label="__('post.fields.excerpt')"
                                :placeholder="__('post.placeholders.excerpt')"
                                rows="4"
                                :value="old('excerpt', $post->excerpt)"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <x-admin.forms.content-editor
                                name="content"
                                id="post-content"
                                :label="__('post.fields.content')"
                                :placeholder="__('post.placeholders.content')"
                                :value="old('content', $post->content)"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="status"
                            :label="__('post.fields.status')"
                            :options="$statuses"
                            :value="old('status', $post->status->value)"
                            :placeholder="__('post.placeholders.status')"
                        />
                    </div>

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
                                @checked((bool) old('is_featured', $post->is_featured))
                            >

                            <label
                                class="form-check-label"
                                for="post-is-featured"
                            >
                                {{ __('post.fields.is_featured') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="published_at"
                            type="text"
                            id="post-published-at"
                            :label="__('post.fields.published_at')"
                            :placeholder="__('post.placeholders.published_at')"
                            :value="old('published_at', $publishedAt)"
                            jdp
                        />
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.file-upload
                            name="image"
                            id="post-image"
                            :label="__('post.fields.image')"
                            :multiple="false"
                            :allowReorder="false"
                            :maxFiles="1"
                            :existingFile="$imageUrl"
                        />
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            {{ __('post.actions.update') }}
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
