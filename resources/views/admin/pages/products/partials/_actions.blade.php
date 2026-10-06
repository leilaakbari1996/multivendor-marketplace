<x-admin.table.actions
    :edit-url="route('panel.product.edit', $row->id)"
    :delete-url="route('panel.product.destroy', $row->id)"
/>
