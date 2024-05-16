<?php


namespace App\Modules\Auth\Responsible\DTO;

use App\Helpers\Files;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class ResponsibleDTO extends DataTransferObject
{

    /** @var string $fname */
    public $fname;

    /** @var string $mname */
    public $mname;

    /** @var string $lname */
    public $lname;

    /** @var string $phone */
    public $phone;

    /** @var string $email */
    public $email;

    /** @var string $password */
    public $password;

    /** @var string $address */
    public $address;

    /** @var string $image */
    public $image;

    public static function fromRequest($request)
    {
        return new self(
            [
                'fname' => $request['fname'],
                'mname' => $request['mname'],
                'lname' => $request['lname'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'address' => $request['address'],
                'image' => $request['image'] ?? 'storage/avatar.png',
            ]
        );
    }

    public static function fromRequestForUpdate($request, $data)
    {
        return new self(
            [
                'fname' => isset($request['fname']) ? $request['fname'] : $data->fname,
                'mname' => isset($request['mname']) ? $request['mname'] : $data->mname,
                'lname' => isset($request['lname']) ? $request['lname'] : $data->lname,
                'phone' => isset($request['phone']) ? $request['phone'] : $data->phone,
                'email' => isset($request['email']) ? $request['email'] : $data->email,
                'password' => isset($request['password']) && $request['password'] ? Hash::make($request['password']) : $data->password,
                'address' => isset($request['address']) ? $request['address'] : $data->address,
                'image' => isset($request['image']) ? $request['image'] : 'storage/avatar.png',
            ]
        );
    }
}
