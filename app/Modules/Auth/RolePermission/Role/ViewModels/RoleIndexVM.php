<?php

namespace App\Modules\Auth\RolePermission\Role\ViewModels;

use App\Modules\Auth\RolePermission\Role\Models\Role;

class RoleIndexVM
{

    public static function handle()
    {
        $roles = Role::where('locked', 0)->get();
        $arr = [];
        foreach ($roles as $role) {
            $roleVM = new RoleShowVM();
            array_push($arr, $roleVM->toAttr($role));
        }
        return $arr;
    }

    public static function toArray()
    {
        return ['roles' => self::handle()];
    }
}
