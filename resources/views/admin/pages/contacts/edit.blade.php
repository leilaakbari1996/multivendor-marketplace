@php
    use App\Constants\AdminView;
    use App\Enums\ContactMessageStatus;
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
                'title' => 'پیام‌ها و درخواست‌ها',
                'url' => route(AdminView::PERFIX_ROUTE . 'contacts.index'),
            ],
        ]"
        current="مشاهده و ویرایش پیام"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'contacts.update', $contactMessage->id) }}"
        method="post"
    >
        @csrf
        @method('PUT')

        <div class="row layout-top-spacing">

            {{-- Main content --}}
            <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="name"
                                label="نام درخواست‌کننده"
                                :value="$contactMessage->name"
                                readonly
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="phone"
                                label="شماره تلفن"
                                :value="$contactMessage->phone"
                                dir="ltr"
                                class="text-end"
                                readonly
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="email"
                                label="ایمیل"
                                :value="$contactMessage->email"
                                dir="ltr"
                                class="text-end"
                                readonly
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="subject"
                                label="موضوع"
                                :value="$contactMessage->subject->label()"
                                readonly
                            />
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message">متن پیام</label>
                                <textarea
                                    id="message"
                                    rows="7"
                                    class="form-control"
                                    readonly
                                >{{ $contactMessage->message }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="ip"
                                label="آی‌پی"
                                :value="$contactMessage->ip"
                                dir="ltr"
                                class="text-end"
                                readonly
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="created_at"
                                label="تاریخ ارسال"
                                :value="\App\Support\DateHelper::toJalali($contactMessage->created_at)"
                                readonly
                            />
                        </div>
                    </div>

                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-4">

                <div class="widget-content widget-content-area blog-create-section">

                    <div class="col-xxl-12 col-md-12 mb-4">
                        <x-admin.forms.tom-select
                            name="status"
                            label="وضعیت پیام"
                            :options="ContactMessageStatus::options()"
                            :value="old('status', $contactMessage->status->value)"
                            placeholder="انتخاب وضعیت"
                        />
                    </div>

                    <div class="col-xxl-12 col-sm-4 col-12 mx-auto">
                        <x-admin.forms.button type="submit" class="btn-primary w-100">
                            ذخیره وضعیت
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
@endpush
