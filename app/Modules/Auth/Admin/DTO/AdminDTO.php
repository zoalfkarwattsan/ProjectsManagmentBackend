<?php


namespace App\Modules\Auth\Admin\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class AdminDTO extends DataTransferObject
{

    /** @var string $name */
    public $name;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /** @var string $phone */
    public $phone;

    /** @var string $role_id */
    public $role_id;

    public static function fromRequest($request)
    {
        return new self([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
        ]);
    }

    public static function fromRequestForUpdate($request, $user)
    {
        return new self([
            'name' => isset($request['name']) ? $request['name'] : $user->name,
            'email' => isset($request['email']) ? $request['email'] : $user->email,
            'phone' => isset($request['phone']) ? $request['phone'] : $user->phone,
            'password' => isset($request['password']) ? Hash::make($request['password']) : $user->password,
            'role_id' => isset($request['role_id']) ? $request['role_id'] : $user->role_id
        ]);
    }
}
