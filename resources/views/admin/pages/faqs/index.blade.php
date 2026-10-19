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
                'title' => __('faq.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'faq.index'),
            ],
        ]"
        :current="__('faq.list')"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route(AdminView::PREFIX_ROUTE . 'faq.data') }}"
                >
                    <thead>
                    <tr>
                        <th>{{ __('faq.columns.question') }}</th>
                        <th>{{ __('faq.columns.categories') }}</th>
                        <th>{{ __('faq.columns.sort_order') }}</th>
                        <th>{{ __('faq.columns.status') }}</th>
                        <th>{{ __('faq.columns.actions') }}</th>
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
                    data: 'question',
                    name: 'question',
                },
                {
                    data: 'categories',
                    name: 'categories',
                    defaultContent: '-',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'sort_order',
                    name: 'sort_order',
                    searchable: false,
                },
                {
                    data: 'is_active',
                    name: 'is_active',
                    searchable: false,
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                },
            ],
        };
    </script>

    @include('admin.assets.list_js')
@endpush
