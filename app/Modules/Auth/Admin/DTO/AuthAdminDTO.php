<?php


namespace App\Modules\Auth\Admin\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class AuthAdminDTO extends DataTransferObject
{

  /** @var string $email */
  public $email;

  /** @var string $password */
  public $password;

  /** @var boolean $remember_me */
  public $remember_me;

  public static function fromRequest($request)
  {
    return new self([
      'email' => $request['email'],
      'password' => $request['password'],
      'remember_me' => $request['remember_me']
    ]);
  }
}
