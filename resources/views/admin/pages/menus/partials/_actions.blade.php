<x-admin.table.actions
    :edit-url="route('panel.menu.edit', $row->id)"
    :delete-url="route('panel.menu.destroy', $row->id)"
/>
