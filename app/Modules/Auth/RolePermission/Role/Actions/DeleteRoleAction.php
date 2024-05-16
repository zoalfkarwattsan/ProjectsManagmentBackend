<?php


namespace App\Modules\Auth\RolePermission\Role\Actions;

use App\Modules\Auth\RolePermission\Role\Models\Role;

class DeleteRoleAction
{
    public static function execute(Role $role)
    {
        $role->delete();
    }

}
