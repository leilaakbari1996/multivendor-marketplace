@extends('admin.layouts.app')

@push('styles')
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/src/table/datatable/datatables.css') }}"
    >
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/css/light/table/datatable/dt-global_style.css') }}"
    >
    <link
        rel="stylesheet"
        type="text/css"
        href="{{ asset('admin/src/plugins/css/dark/table/datatable/dt-global_style.css') }}"
    >
@endpush

@section('content')

    <x-admin.breadcrumb
        :items="[
            [
                'title' => 'نقش‌ها',
                'url' => route('panel.role.index'),
            ],
        ]"
        current="لیست نقش‌ها"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.role.data') }}"
                >
                    <thead>
                    <tr>
                        <th>نام نقش</th>
                        <th>نام نقش(به انگلیسی)</th>
                        <th>تعداد دسترسی‌ها</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                </table>

            </div>

        </div>
    </div>

@endsection

@push('scripts')

    <script src="{{ asset('admin/src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('admin/src/assets/js/custom.js') }}"></script>

    <script>
        window.dataTableConfig = {
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'name_en',
                    name: 'name_en'
                },
                {
                    data: 'permissions_count',
                    name: 'permissions_count',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        };
    </script>

    @include('admin.assets.list_js')

@endpush
