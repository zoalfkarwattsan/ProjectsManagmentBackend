<?php


namespace App\Modules\Auth\RolePermission\Permission\Actions;

use App\Modules\Auth\RolePermission\Permission\DTO\PermissionDTO;
use App\Modules\Auth\RolePermission\Permission\Models\Permission;

class StorePermissionAction
{

    public static function execute(PermissionDTO $permissionDTO)
    {
        $permission = new Permission($permissionDTO->toArray());
        $permission->save();
        return $permission;
    }
}
