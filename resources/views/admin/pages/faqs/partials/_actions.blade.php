<x-admin.table.actions
    :edit-url="route('panel.faq.edit', $row->id)"
    :delete-url="route('panel.faq.destroy', $row->id)"
/>
