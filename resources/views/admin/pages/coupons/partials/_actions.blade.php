<x-admin.table.actions
    :edit-url="route('panel.coupon.edit', $row->id)"
    :delete-url="route('panel.coupon.destroy', $row->id)"
/>
