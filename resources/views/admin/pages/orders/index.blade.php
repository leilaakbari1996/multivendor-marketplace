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
        :items="[]"
        current="لیست سفارش‌ها"
    />

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.order.data') }}"
                >
                    <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>کاربر</th>
                        <th>کد تخفیف</th>
                        <th>مبلغ کل</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody></tbody>

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
                    data: 'order_number',
                    name: 'order_number',
                    defaultContent: '-'
                },
                {
                    data: 'user',
                    name: 'user',
                    defaultContent: '-'
                },
                {
                    data: 'coupon',
                    name: 'coupon',
                    orderable: false,
                    searchable: false,
                    defaultContent: '-'
                },
                {
                    data: 'total',
                    name: 'total',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false
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
