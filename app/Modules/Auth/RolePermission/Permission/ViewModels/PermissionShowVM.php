<?php

namespace App\Modules\Auth\RolePermission\Permission\ViewModels;

use App\Modules\Auth\RolePermission\Permission\Models\Permission;

class PermissionShowVM
{

    public static function handle($permission)
    {
        return $permission;
    }

    public static function toArray(Permission $permission)
    {
        return ['permission' => self::handle($permission)];
    }

    public static function toAttr(Permission $permission)
    {
        return self::handle($permission);
    }
}
