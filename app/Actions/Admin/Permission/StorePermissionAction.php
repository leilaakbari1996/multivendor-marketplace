<?php

namespace App\Actions\Admin\Permission;

use App\Models\Permission;
use Illuminate\Support\Str;

class StorePermissionAction
{
    public function execute(array $data): Permission
    {
        return Permission::create($data);
    }
}
