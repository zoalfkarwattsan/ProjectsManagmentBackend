<?php


namespace App\Modules\Auth\RolePermission\Role\Actions;

use App\Modules\Auth\RolePermission\Role\DTO\RoleDTO;
use Spatie\Permission\Models\Role;


class AssignPermissionToRole
{
    public static function execute($roleId, $permissions)
    {
        $role = Role::find($roleId);
        $role->syncPermissions($permissions);
        return $role;
    }

}
