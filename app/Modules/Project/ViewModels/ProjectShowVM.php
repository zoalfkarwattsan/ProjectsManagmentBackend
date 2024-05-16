<?php

namespace App\Modules\Project\ViewModels;

use App\Modules\Project\Models\Project;

class ProjectShowVM
{

  public static function handle($item)
  {
    return $item;
  }

  public static function toArray(Project $item)
  {
    return ['project' => self::handle($item)];
  }

  public static function toAttr(Project $item)
  {
    return self::handle($item);
  }
}
