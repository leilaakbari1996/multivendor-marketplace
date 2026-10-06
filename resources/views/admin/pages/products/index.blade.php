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
                'title' => 'محصولات',
                'url' => route('panel.product.index'),
            ],
        ]"
        current="لیست محصولات"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route('panel.product.data') }}"
                >
                    <thead>
                    <tr>
                        <th>نام محصول</th>
                        <th>فروشنده</th>
                        <th>دسته‌بندی</th>
                        <th>قیمت</th>
                        <th>موجودی</th>
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
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'vendor.store_name',
                    name: 'vendor.store_name',
                    defaultContent: '-',
                    searchable: false
                },
                {
                    data: 'category.name',
                    name: 'category.name',
                    defaultContent: '-',
                    searchable: false
                },
                {
                    data: 'price',
                    name: 'price',
                    searchable: false
                },
                {
                    data: 'stock',
                    name: 'stock',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
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
