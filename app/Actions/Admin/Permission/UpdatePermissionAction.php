<?php

namespace App\Actions\Admin\Permission;

use App\Models\Permission;

class UpdatePermissionAction
{
    public function execute(
        Permission $permission,
        array $data
    ): Permission {

        $permission->update($data);

        return $permission->refresh();
    }
}
