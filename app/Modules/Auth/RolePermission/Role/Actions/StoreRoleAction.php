<?php


namespace App\Modules\Auth\RolePermission\Role\Actions;

use App\Modules\Auth\RolePermission\Role\DTO\RoleDTO;
use App\Modules\Auth\RolePermission\Role\Models\Role;

class StoreRoleAction
{

    public static function execute(RoleDTO $roleDTO)
    {
        $role = new Role($roleDTO->toArray());
        $role->save();
        return $role;
    }
}
