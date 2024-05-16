<?php

namespace App\Modules\Election\ViewModels;

use App\Modules\Election\Models\Election;

class ElectionShowVM
{

  public static function handle($election)
  {
    return $election;
  }

  public static function toArray(Election $election)
  {
    return ['election' => self::handle($election)];
  }

  public static function toAttr(Election $election)
  {
    return self::handle($election);
  }
}
