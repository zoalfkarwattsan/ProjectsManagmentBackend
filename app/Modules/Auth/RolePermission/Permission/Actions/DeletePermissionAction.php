<?php


namespace App\Modules\Auth\RolePermission\Permission\Actions;

use App\Modules\Auth\RolePermission\Permission\Models\Permission;

class DeletePermissionAction
{
    public static function execute(Permission $permission)
    {
        $permission->delete();
    }

}
