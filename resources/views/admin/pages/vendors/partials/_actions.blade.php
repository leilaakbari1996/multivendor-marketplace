<x-admin.table.actions
    :edit-url="route('panel.vendor.edit', $row->id)"
    :delete-url="route('panel.vendor.destroy', $row->id)"
/>
