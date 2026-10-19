@use('App\Constants\AdminView')

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
                'title' => __('category.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'category.index'),
            ],
        ]"
        :current="__('category.list')"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route(AdminView::PREFIX_ROUTE . 'category.data') }}"
                >
                    <thead>
                    <tr>
                        <th>{{ __('category.columns.name') }}</th>
                        <th>{{ __('category.columns.type') }}</th>
                        <th>{{ __('category.columns.parent') }}</th>
                        <th>{{ __('category.columns.status') }}</th>
                        <th>{{ __('category.columns.is_main') }}</th>
                        <th>{{ __('category.columns.products_count') }}</th>
                        <th>{{ __('category.columns.actions') }}</th>
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
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'parent.name',
                    name: 'parent.name',
                    defaultContent: '-',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    searchable: false
                },
                {
                    data: 'is_main',
                    name: 'is_main',
                    searchable: false
                },
                {
                    data: 'products_count',
                    name: 'products_count',
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
