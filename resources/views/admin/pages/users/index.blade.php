
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
                'title' => 'کاربران',
                'url' => route('panel.user.index'),
            ],
        ]"
        current="لیست کاربران"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.user.data') }}"
                >
                    <thead>
                    <tr>
                        <th>نام کاربری</th>
                        <th>شماره موبایل</th>
                        <th>نوع کاربر</th>
                        <th>وضعیت</th>
                        <th>تأیید موبایل</th>
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
                    data: 'user_name',
                    name: 'user_name',
                    defaultContent: '-'
                },
                {
                    data: 'mobile',
                    name: 'mobile'
                },
                {
                    data: 'type',
                    name: 'type',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false
                },
                {
                    data: 'mobile_verified_at',
                    name: 'mobile_verified_at',
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


