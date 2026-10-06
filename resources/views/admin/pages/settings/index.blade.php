@php
    use App\Constants\AdminView;
@endphp

@extends('admin.layouts.app')

@push('styles')
    @include('admin.assets.create_css')
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[]"
        current="تنظیمات سایت"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'setting.update') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            @foreach ($settings as $setting)

                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">

                    <div class="widget-content widget-content-area">

                        @switch($setting['type'])

                            @case('text')
                            @case('email')

                                <x-admin.forms.input
                                    :name="$setting['name']"
                                    :label="$setting['label']"
                                    :type="$setting['type']"
                                    :value="old(
                                        $setting['name'],
                                        $setting['value'] ?? null
                                    )"
                                    :placeholder="$setting['placeholder'] ?? null"
                                    :required="$setting['required'] ?? false"
                                />

                                @break

                            @case('textarea')

                                <x-admin.forms.textarea
                                    :name="$setting['name']"
                                    :label="$setting['label']"
                                    :value="old(
                                        $setting['name'],
                                        $setting['value'] ?? null
                                    )"
                                    :placeholder="$setting['placeholder'] ?? null"
                                    :required="$setting['required'] ?? false"
                                />

                                @break

                            @case('image')

                                <x-admin.forms.file-upload
                                    :name="$setting['name']"
                                    :label="$setting['label']"
                                    :existingFile="$setting['value'] ?? null"
                                />

                                @break

                        @endswitch

                    </div>

                </div>

            @endforeach

            <div class="col-12">

                <div class="widget-content widget-content-area">

                    <x-admin.forms.button
                        type="submit"
                        class="btn-success"
                    >
                        ذخیره تنظیمات
                    </x-admin.forms.button>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('scripts')

    @include('admin.assets.create_js')

@endpush
