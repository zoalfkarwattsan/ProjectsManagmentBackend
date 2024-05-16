<?php

namespace App\Modules\Auth\Notification\ViewModels;

use App\Modules\Auth\Notification\Models\Notification;

class NotificationIndexVM
{

  public static function handle()
  {
    $users = Notification::all();
    $arr = [];
    foreach ($users as $user) {
      $userVM = new NotificationShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['users' => self::handle()];
  }
}
