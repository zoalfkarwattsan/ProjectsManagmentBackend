<?php


namespace App\Modules\Auth\RolePermission\Permission\Actions;

use App\Modules\Auth\RolePermission\Permission\DTO\PermissionDTO;
use App\Modules\Auth\RolePermission\Permission\Models\Permission;

class UpdatePermissionAction
{
    public static function execute(Permission $permission, PermissionDTO $permissionDTO)
    {
        $permission->update($permissionDTO->toArray());
        return $permission;
    }

}
