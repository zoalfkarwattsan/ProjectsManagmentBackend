<?php

namespace App\Modules\Auth\RolePermission\Role\ViewModels;

use App\Modules\Auth\RolePermission\Role\Models\Role;

class RoleShowVM
{

    public static function handle($role)
    {
        return $role;
    }

    public static function toArray(Role $role)
    {
        return ['role' => self::handle($role)];
    }

    public static function toAttr(Role $role)
    {
        return self::handle($role);
    }
}
