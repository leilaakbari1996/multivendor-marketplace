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
                'title' => 'فروشندگان',
                'url' => route('panel.vendor.index'),
            ],
        ]"
        current="لیست فروشندگان"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.vendor.data') }}"
                >
                    <thead>
                    <tr>
                        <th>نام فروشگاه</th>
                        <th>کاربر</th>
                        <th>کمیسیون</th>
                        <th>وضعیت</th>
                        <th>کد ملی</th>
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
                    data: 'store_name',
                    name: 'store_name'
                },
                {
                    data: 'user.user_name',
                    name: 'user.user_name',
                    // defaultContent: '-',
                    // searchable: false
                },
                {
                    data: 'commission_rate',
                    name: 'commission_rate',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false
                },
                {
                    data: 'national_code',
                    name: 'national_code'
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
