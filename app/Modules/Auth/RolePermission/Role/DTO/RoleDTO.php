<?php


namespace App\Modules\Auth\RolePermission\Role\DTO;

use Spatie\DataTransferObject\DataTransferObject;


class RoleDTO extends DataTransferObject
{

    /** @var string $name */
    public $name;

    /** @var string $description */
    public $description;

    /** @var string $guard_name */
    public $guard_name;

    public static function fromRequest($request)
    {
        return new self([
            'name' => $request['name'],
            'description' => $request['description'],
            'guard_name' => 'web',
        ]);
    }

    public static function fromRequestForUpdate($request, $role)
    {
        return new self([
            'name' => isset($request['name']) ? $request['name'] : $role->name,
            'description' => isset($request['description']) ? $request['description'] : $role->description,
            'guard_name' => isset($request['guard_name']) ? $request['guard_name'] : $role->guard_name,
        ]);
    }
}
