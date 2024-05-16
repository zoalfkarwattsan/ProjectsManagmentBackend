<?php

namespace App\Modules\Task\ViewModels;

use App\Modules\Task\Models\Task;

class TaskIndexByProjectVM
{

  public static function handle()
  {
    $items = Task::all();
    $arr = [];
    foreach ($items as $item) {
      $itemVM = new TaskShowVM();
      array_push($arr, $itemVM->toAttr($item));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['tasks' => self::handle()];
  }
}
