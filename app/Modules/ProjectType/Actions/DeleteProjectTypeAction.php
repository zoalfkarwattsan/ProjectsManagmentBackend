<?php


namespace App\Modules\ProjectType\Actions;


use App\Modules\ProjectType\Models\ProjectType;

class DeleteProjectTypeAction
{
  public static function execute(ProjectType $projectType)
  {
    $projectType->delete();
  }

}
