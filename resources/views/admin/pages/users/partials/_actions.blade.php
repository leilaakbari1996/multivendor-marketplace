<x-admin.table.actions
    :edit-url="route('panel.user.edit', $row->id)"
    :delete-url="route('panel.user.destroy', $row->id)"
/>
