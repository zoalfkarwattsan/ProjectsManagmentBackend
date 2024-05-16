<?php

namespace App\Modules\Box\ViewModels;

use App\Modules\Box\Models\Box;

class BoxIndexVM
{

  public static function handle()
  {
    $boxes = Box::all();
    $arr = [];
    foreach ($boxes as $box) {
      $boxVM = new BoxShowVM();
      array_push($arr, $boxVM->toAttr($box));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['boxes' => self::handle()];
  }
}
