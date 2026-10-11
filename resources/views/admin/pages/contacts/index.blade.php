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
        current="لیست پیامها و درخواست های مشتریان"
    />

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.contacts.data') }}"
                >
                    <thead>
                    <tr>
                        <th>نام درخواست کننده</th>
                        <th>شماره تلفن درخواست کننده</th>
                        <th>موضوع</th>
                        <th>وضعیت</th>
                        <th>تاریخ ارسال پیام</th>
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
                    name: 'name',
                    defaultContent: '-'
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'subject',
                    name: 'subject',
                    searchable: true
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
