<?php

namespace App\Modules\Task\ViewModels;

use App\Modules\Task\Models\Task;

class TaskIndexVM
{

  public static function handle()
  {
    $users = Task::all();
    $arr = [];
    foreach ($users as $user) {
      $userVM = new TaskShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['users' => self::handle()];
  }
}
