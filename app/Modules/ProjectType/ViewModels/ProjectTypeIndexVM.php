<?php

namespace App\Modules\ProjectType\ViewModels;

use App\Modules\ProjectType\Models\ProjectType;

class ProjectTypeIndexVM
{

  public static function handle()
  {
    $projectTypes = ProjectType::all();
    $arr = [];
    foreach ($projectTypes as $projectType) {
      $projectTypeVM = new ProjectTypeShowVM();
      array_push($arr, $projectTypeVM->toAttr($projectType));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['projectTypes' => self::handle()];
  }
}
