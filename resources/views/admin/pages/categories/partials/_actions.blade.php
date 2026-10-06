<x-admin.table.actions
    :edit-url="route('panel.category.edit', $row->id)"
    :delete-url="route('panel.category.destroy', $row->id)"
/>
