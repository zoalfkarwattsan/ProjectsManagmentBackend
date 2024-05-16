<?php

namespace App\Modules\Task\ViewModels;

use App\Modules\Task\Models\Task;

class TaskShowVM
{

  public static function handle($user)
  {
    return $user;
  }

  public static function toArray(Task $user)
  {
    return ['user' => self::handle($user)];
  }

  public static function toAttr(Task $user)
  {
    return self::handle($user);
  }
}
