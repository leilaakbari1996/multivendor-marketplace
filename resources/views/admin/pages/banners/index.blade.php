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
                'title' => __('banner.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'banner.index'),
            ],
        ]"
        :current="__('banner.list')"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route(AdminView::PREFIX_ROUTE . 'banner.data') }}"
                >
                    <thead>
                    <tr>
                        <th>{{ __('banner.columns.title') }}</th>
                        <th>{{ __('banner.columns.subtitle') }}</th>
                        <th>{{ __('banner.columns.position') }}</th>
                        <th>{{ __('banner.columns.sort_order') }}</th>
                        <th>{{ __('banner.columns.status') }}</th>
                        <th>{{ __('banner.columns.actions') }}</th>
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
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'subtitle',
                    name: 'subtitle',
                    defaultContent: '-'
                },
                {
                    data: 'position',
                    name: 'position'
                },
                {
                    data: 'sort_order',
                    name: 'sort_order',
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
