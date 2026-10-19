@use('App\Constants\AdminView')
@use('App\Support\AuthUser')

@php
    // $user->can() checks the policy for this exact user,
    // so it works even when admins log in with a non-default guard.
    $user = AuthUser::user();
@endphp

<x-admin.table.actions
    :edit-url="$user?->can('update', $row)
        ? route(AdminView::PREFIX_ROUTE . 'banner.edit', $row->id)
        : null"
    :delete-url="$user?->can('delete', $row)
        ? route(AdminView::PREFIX_ROUTE . 'banner.destroy', $row->id)
        : null"
/>
