<?php

namespace App\Modules\Auth\Admin\ViewModels;

use App\Modules\Auth\Admin\Models\Admin;

class AdminShowVM
{

  public static function handle($user)
  {
    return $user;
  }

  public static function toArray(Admin $user)
  {
    return ['user' => self::handle($user)];
  }

  public static function toAttr(Admin $user)
  {
    return self::handle($user);
  }
}
