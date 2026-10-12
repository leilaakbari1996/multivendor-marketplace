@php
    use App\Constants\AdminView;
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
                'title' => 'سوالات متداول',
                'url' => route(AdminView::PERFIX_ROUTE . 'faq.index'),
            ],
        ]"
        current="ویرایش سوال متداول"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'faq.update', $faq) }}"
        method="post"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- Main content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.input
                                name="question"
                                id="faq-question"
                                label="سوال"
                                placeholder="متن سوال"
                                :value="$faq->question"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="answer"
                                label="پاسخ"
                                placeholder="متن پاسخ"
                                rows="8"
                                :value="$faq->answer"
                            />
                        </div>

                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    {{-- Categories --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <label for="faq-categories" class="form-label">دسته بندی</label>

                        <select
                            name="categories[]"
                            id="faq-categories"
                            multiple
                            placeholder="انتخاب دسته بندی"
                        >
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(in_array($category->id, (array) old('categories', $selectedCategories)))
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

                    {{-- Icon --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.input
                            name="icon"
                            id="faq-icon"
                            label="آیکن"
                            placeholder="bi-question-circle"
                            :value="old('icon', $faq->icon)"
                        />

                        <small class="text-muted">
                            نام کلاس Bootstrap Icons، مثلاً bi-truck
                        </small>

                    </div>

                    {{-- Sort order --}}
                    <div class="col-xxl-12 col-md-12 mb-4">

                        <x-admin.forms.input
                            name="sort_order"
                            type="number"
                            id="faq-sort-order"
                            label="ترتیب نمایش"
                            placeholder="ترتیب نمایش"
                            min="0"
                            :value="$faq->sort_order"
                        />

                    </div>

                    {{-- Active --}}
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
                                @checked(old('is_active', $faq->is_active))
                            >

                            <label
                                class="form-check-label"
                                for="faq-is-active"
                            >
                                فعال
                            </label>

                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">

                        <x-admin.forms.button
                            type="submit"
                            class="btn-success w-100"
                        >
                            بروزرسانی سوال
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
