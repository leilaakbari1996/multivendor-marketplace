@php
    use App\Constants\AdminView;
@endphp

@extends('admin.layouts.app')

@push('styles')
    @include('admin.assets.create_css')
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'نقش‌ها',
                'url' => route(AdminView::PERFIX_ROUTE . 'role.index'),
            ],
        ]"
        current="ایجاد نقش"
    />

    <form
        action="{{ route(AdminView::PERFIX_ROUTE . 'role.store') }}"
        method="post"
    >
        @csrf

        <div class="row layout-top-spacing">

            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                {{-- اطلاعات نقش --}}
                <div class="widget-content widget-content-area blog-create-section">

                    <h5 class="mb-4">اطلاعات نقش</h5>

                    <div class="row mb-4">

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="name"
                                id="role-name"
                                label="نام فارسی"
                                placeholder="نام فارسی نقش"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-admin.forms.input
                                name="name_en"
                                id="role-name-en"
                                label="نام انگلیسی"
                                placeholder="نام انگلیسی نقش"
                            />
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">
                            <x-admin.forms.textarea
                                name="description"
                                id="role-description"
                                label="توضیحات"
                                placeholder="توضیحات نقش"
                                rows="6"
                            />
                        </div>

                    </div>

                </div>

                {{-- دسترسی‌ها --}}
                <div class="widget-content widget-content-area mt-4">

                    <h5 class="mb-4">دسترسی‌ها</h5>

                    @forelse($permissions as $group => $groupPermissions)

                        <div class="mb-4">

                            <h6 class="mb-3">
                                {{ $group }}
                            </h6>

                            <div class="row">

                                @foreach($groupPermissions as $permission)

                                    <div class="col-md-4 mb-3">

                                        <x-admin.forms.checkbox
                                            name="permissions[]"
                                            :id="'permission-' . $permission->id"
                                            :value="$permission->id"
                                            :label="$permission->name"
                                            :checked="in_array(
                                                $permission->id,
                                                old('permissions', [])
                                            )"
                                        />

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @empty

                        <div class="alert alert-warning mb-0">
                            هنوز هیچ دسترسی‌ای ایجاد نشده است.
                        </div>

                    @endforelse

                </div>

                {{-- ثبت --}}
                <div class="mt-4">

                    <x-admin.forms.button
                        type="submit"
                        class="btn-success"
                    >
                        ایجاد نقش
                    </x-admin.forms.button>

                </div>

            </div>

        </div>

    </form>

@endsection

@push('scripts')

    @include('admin.assets.create_js')

@endpush
