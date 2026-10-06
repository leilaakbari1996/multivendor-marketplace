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
        current="لیست کدهای تخفیف"
    />

    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.coupon.data') }}"
                >
                    <thead>
                    <tr>
                        <th>کد تخفیف</th>
                        <th>نوع تخفیف</th>
                        <th>مقدار تخفیف</th>
                        <th>محدودیت استفاده</th>
                        <th>شروع اعتبار</th>
                        <th>پایان اعتبار</th>
                        <th>وضعیت</th>
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
                    data: 'code',
                    name: 'code',
                    defaultContent: '-'
                },
                {
                    data: 'type',
                    name: 'type',
                    searchable: false
                },
                {
                    data: 'value',
                    name: 'value',
                    searchable: false
                },
                {
                    data: 'usage',
                    name: 'usage',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'starts_at',
                    name: 'starts_at',
                    searchable: false
                },
                {
                    data: 'expires_at',
                    name: 'expires_at',
                    searchable: false
                },
                {
                    data: 'is_active',
                    name: 'is_active',
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
