<x-admin.table.actions
    :edit-url="route('panel.post.edit', $row->id)"
    :delete-url="route('panel.post.destroy', $row->id)"
/>
