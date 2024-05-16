<?php

namespace App\Modules\Auth\Notification\ViewModels;

use App\Modules\Auth\Notification\Models\Notification;

class NotificationShowVM
{

  public static function handle($user)
  {
    return $user;
  }

  public static function toArray(Notification $user)
  {
    return ['user' => self::handle($user)];
  }

  public static function toAttr(Notification $user)
  {
    return self::handle($user);
  }
}
