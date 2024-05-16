<?php

namespace App\Modules\Auth\Responsible\ViewModels;

use App\Modules\Auth\Responsible\Models\Responsible;

class ResponsibleShowVM
{

  public static function handle($responsible)
  {
    return $responsible;
  }

  public static function toArray(Responsible $responsible)
  {
    return ['user' => self::handle($responsible)];
  }

  public static function toAttr(Responsible $responsible)
  {
    return self::handle($responsible);
  }
}
