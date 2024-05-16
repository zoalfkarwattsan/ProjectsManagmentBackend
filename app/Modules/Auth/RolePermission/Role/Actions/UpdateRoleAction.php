<?php


namespace App\Modules\Auth\RolePermission\Role\Actions;

use App\Modules\Auth\RolePermission\Role\DTO\RoleDTO;
use App\Modules\Auth\RolePermission\Role\Models\Role;

class UpdateRoleAction
{
    public static function execute(Role $role, RoleDTO $roleDTO)
    {
        $role->update($roleDTO->toArray());
        return $role;
    }

}
