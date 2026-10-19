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
        :items="[]"
        :current="__('post.list')"
    />

    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-8">
                <table
                    id="list"
                    class="table table-hover"
                    data-ajax-url="{{ route(AdminView::PREFIX_ROUTE . 'post.data') }}"
                >
                    <thead>
                    <tr>
                        <th>{{ __('post.columns.title') }}</th>
                        <th>{{ __('post.columns.author') }}</th>
                        <th>{{ __('post.columns.status') }}</th>
                        <th>{{ __('post.columns.is_featured') }}</th>
                        <th>{{ __('post.columns.published_at') }}</th>
                        <th>{{ __('post.columns.actions') }}</th>
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
                    name: 'title',
                    defaultContent: '-',
                },
                {
                    data: 'author',
                    name: 'author',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                },
                {
                    data: 'is_featured',
                    name: 'is_featured',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'published_at',
                    name: 'published_at',
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
