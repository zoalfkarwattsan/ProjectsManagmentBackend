<?php

namespace App\Modules\Election\ViewModels;

use App\Modules\Election\Models\Election;

class ElectionIndexVM
{

  public static function handle()
  {
    $elections = Election::all();
    $arr = [];
    foreach ($elections as $election) {
      $electionVM = new ElectionShowVM();
      array_push($arr, $electionVM->toAttr($election));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['elections' => self::handle()];
  }
}
