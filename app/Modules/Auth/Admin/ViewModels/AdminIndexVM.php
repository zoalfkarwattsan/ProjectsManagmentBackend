<?php

namespace App\Modules\Auth\Admin\ViewModels;

use App\Modules\Auth\Admin\Models\Admin;

class AdminIndexVM
{

  public static function handle()
  {
    $users = Admin::all();
    $arr = [];
    foreach ($users as $user) {
      $userVM = new AdminShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['users' => self::handle()];
  }
}
