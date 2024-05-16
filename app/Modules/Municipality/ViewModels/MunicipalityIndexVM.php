<?php

namespace App\Modules\Municipality\ViewModels;

use App\Modules\Municipality\Models\Municipality;

class MunicipalityIndexVM
{

  public static function handle()
  {
    $municipalities = Municipality::all();
    $arr = [];
    foreach ($municipalities as $municipality) {
      $municipalityVM = new MunicipalityShowVM();
      array_push($arr, $municipalityVM->toAttr($municipality));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['municipalities' => self::handle()];
  }
}
