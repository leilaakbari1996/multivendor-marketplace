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
                'title' => 'منوها',
                'url' => route(AdminView::PERFIX_ROUTE . 'menu.index'),
            ],
        ]"
        current="ویرایش منو"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'menu.update', $menu) }}"
        method="post"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">

                        <div class="col-xxl-6 col-md-6 col-sm-12 mb-4">
                            <x-admin.forms.input
                                name="title"
                                id="menu-title"
                                label="عنوان"
                                placeholder="عنوان منو"
                                :value="old('title', $menu->title)"
                            />
                        </div>

                        <div class="col-xxl-6">
                            <x-admin.forms.input
                                name="url"
                                id="menu-url"
                                label="آدرس"
                                placeholder="مثال: /shop"
                                :value="old('url', $menu->url)"
                            />
                        </div>

                    </div>

                    <div class="row mb-4">

                        <div class="col-xxl-6 col-md-6 col-sm-12">
                            <x-admin.forms.tom-select
                                name="location"
                                :options="$locations"
                                :value="old('location', $menu->location->value)"
                                placeholder="انتخاب محل نمایش"
                            />
                        </div>

                        <div class="col-xxl-6 col-md-6 col-sm-12">
                            <x-admin.forms.tom-select
                                name="parent_id"
                                :options="$menus->pluck('title', 'id')->toArray()"
                                :value="old('parent_id', $menu->parent_id)"
                                placeholder="انتخاب منوی والد"
                            />
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row">

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.input
                                name="sort_order"
                                type="number"
                                id="sort_order"
                                label="ترتیب نمایش"
                                placeholder="ترتیب نمایش"
                                :value="old('sort_order', $menu->sort_order)"
                            />
                        </div>

                        <div class="col-xxl-12 mb-4">
                            <x-admin.forms.switch
                                name="is_active"
                                label="فعال"
                                :checked="old('is_active', $menu->is_active)"
                            />
                        </div>

                        <div class="col-xxl-12 col-sm-4 col-12 mx-auto">

                            <x-admin.forms.button
                                type="submit"
                                class="btn-success w-100"
                            >
                                ویرایش منو
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
