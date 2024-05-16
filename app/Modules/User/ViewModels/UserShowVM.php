<?php

namespace App\Modules\User\ViewModels;

use App\Modules\User\Models\User;

class UserShowVM
{

  public static function handle($user)
  {
    return $user;
  }

  public static function toArray(User $user)
  {
    return ['user' => self::handle($user)];
  }

  public static function toAttr(User $user)
  {
    return self::handle($user);
  }
}
