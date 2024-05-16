<?php

namespace App\Modules\Auth\RolePermission\Permission\ViewModels;

use App\Modules\Auth\RolePermission\Permission\Models\Permission;

class PermissionIndexVM
{

    public static function handle()
    {
        $permissions = Permission::all();
        $arr = [];
        foreach ($permissions as $permission) {
            $permissionVM = new PermissionShowVM();
            if ($permission->id !== 1) {
                array_push($arr, $permissionVM->toAttr($permission));
            }
        }
        return $arr;
    }

    public static function toArray()
    {
        return ['permissions' => self::handle()];
    }
}
