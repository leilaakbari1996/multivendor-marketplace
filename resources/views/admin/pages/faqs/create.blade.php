@use('App\Constants\AdminView')

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
                'title' => __('faq.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'faq.index'),
            ],
        ]"
        :current="__('faq.create')"
    />

    <form
        action="{{ route(AdminView::PREFIX_ROUTE . 'faq.store') }}"
        method="POST"
    >
        @csrf

        <div class="row layout-top-spacing">
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="row mb-4">
                        <div class="col-12">
                            <x-admin.forms.input
                                name="question"
                                id="faq-question"
                                :label="__('faq.fields.question')"
                                :placeholder="__('faq.placeholders.question')"
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="answer"
                                :label="__('faq.fields.answer')"
                                :placeholder="__('faq.placeholders.answer')"
                                rows="8"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">
                <div class="widget-content widget-content-area blog-create-section">
                    <div class="col-xxl-12 col-md-12 mb-4">
                        <label for="faq-categories" class="form-label">
                            {{ __('faq.fields.categories') }}
                        </label>

                        <select
                            name="categories[]"
                            id="faq-categories"
                            multiple
                            placeholder="{{ __('faq.placeholders.categories') }}"
                        >
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(in_array($category->id, (array) old('categories', [])))
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('categories')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror

                        @error('categories.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="icon"
                            id="faq-icon"
                            :label="__('faq.fields.icon')"
                            :placeholder="__('faq.placeholders.icon')"
                            :value="old('icon', 'bi-question-circle')"
                        />

                        <small class="text-muted">
                            {{ __('faq.help.icon') }}
                        </small>
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.input
                            name="sort_order"
                            type="number"
                            id="faq-sort-order"
                            :label="__('faq.fields.sort_order')"
                            :placeholder="__('faq.placeholders.sort_order')"
                            min="0"
                        />
                    </div>

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <div class="form-check form-switch">
                            <input
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="faq-is-active"
                                value="1"
                                @checked(old('is_active', true))
                            >

                            <label
                                class="form-check-label"
                                for="faq-is-active"
                            >
                                {{ __('faq.fields.is_active') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            {{ __('faq.actions.create') }}
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

    <script>
        new TomSelect('#faq-categories', {
            create: false,
            maxOptions: null,
        });
    </script>
@endpush
