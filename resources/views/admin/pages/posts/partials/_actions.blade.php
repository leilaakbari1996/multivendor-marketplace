@use('App\Constants\AdminView')
@use('App\Support\AuthUser')

@php
    $user = AuthUser::user();
@endphp

<x-admin.table.actions
    :edit-url="$user?->can('update', $row)
        ? route(AdminView::PREFIX_ROUTE . 'post.edit', $row->id)
        : null"
    :delete-url="$user?->can('delete', $row)
        ? route(AdminView::PREFIX_ROUTE . 'post.destroy', $row->id)
        : null"
/>
