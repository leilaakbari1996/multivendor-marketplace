<?php

namespace App\Actions\Admin\Role;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction
{
    public function execute(
        Role $role,
        array $data
    ): Role {
        return DB::transaction(function () use ($role, $data) {

            $permissions = $data['permissions'] ?? [];

            unset($data['permissions']);

            $role->update($data);

            $role->permissions()->sync($permissions);

            return $role->refresh();
        });
    }
}
