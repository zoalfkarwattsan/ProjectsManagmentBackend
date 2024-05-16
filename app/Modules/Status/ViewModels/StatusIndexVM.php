<?php

namespace App\Modules\Status\ViewModels;

use App\Modules\Status\Models\Status;

class StatusIndexVM
{

  public static function handle()
  {
    $statuses = Status::all();
    $arr = [];
    foreach ($statuses as $status) {
      $statusVM = new StatusShowVM();
      array_push($arr, $statusVM->toAttr($status));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['statuses' => self::handle()];
  }
}
