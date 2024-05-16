<?php


namespace App\Modules\Auth\Admin\Actions;


use App\Modules\Auth\Admin\DTO\AuthAdminDTO;
use App\Modules\Auth\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthAdminAction
{
  public static function execute(AuthAdminDTO $adminDTO)
  {
    $credentials = $adminDTO->only('email','password')->toArray();
    if (Auth::guard('web')->attempt($credentials)) return true;
    return false;
  }

}
