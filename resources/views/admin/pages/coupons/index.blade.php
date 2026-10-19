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
                'title' => __('coupon.title'),
                'url' => route(AdminView::PREFIX_ROUTE . 'coupon.index'),
            ],
        ]"
        :current="__('coupon.list')"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">

                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route(AdminView::PREFIX_ROUTE . 'coupon.data') }}"
                >
                    <thead>
                    <tr>
                        <th>{{ __('coupon.columns.code') }}</th>
                        <th>{{ __('coupon.columns.type') }}</th>
                        <th>{{ __('coupon.columns.value') }}</th>
                        <th>{{ __('coupon.columns.usage') }}</th>
                        <th>{{ __('coupon.columns.starts_at') }}</th>
                        <th>{{ __('coupon.columns.expires_at') }}</th>
                        <th>{{ __('coupon.columns.status') }}</th>
                        <th>{{ __('coupon.columns.actions') }}</th>
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
