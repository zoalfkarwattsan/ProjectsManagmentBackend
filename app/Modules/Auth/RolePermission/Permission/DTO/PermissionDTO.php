<?php


namespace App\Modules\Auth\RolePermission\Permission\DTO;

use Spatie\DataTransferObject\DataTransferObject;


class PermissionDTO extends DataTransferObject
{

    /** @var string $name */
    public $name;

    /** @var string $description */
    public $description;

    public static function fromRequest($request)
    {
        return new self([
            'name' => $request['name']
        ]);
    }

    public static function fromRequestForUpdate($request, $permission)
    {
        return new self([
            'name' => isset($request['name']) ? $request['name'] : $permission->name
        ]);
    }
}
