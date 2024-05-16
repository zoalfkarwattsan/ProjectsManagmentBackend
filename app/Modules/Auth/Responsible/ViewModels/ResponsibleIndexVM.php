<?php

namespace App\Modules\Auth\Responsible\ViewModels;

use App\Modules\Auth\Responsible\Models\Responsible;

class ResponsibleIndexVM
{

  public static function handle()
  {
    $users = Responsible::all();
    $arr = [];
    foreach ($users as $user) {
      $userVM = new ResponsibleShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['users' => self::handle()];
  }
}
