<?php

namespace App\Actions\Admin\Role;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class StoreRoleAction
{
    public function execute(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $permissions = $data['permissions'] ?? [];

            unset($data['permissions']);

            $role = Role::create($data);
            $role->permissions()->sync($permissions);

            return $role->refresh();
        });
    }
}
