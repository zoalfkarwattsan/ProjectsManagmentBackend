<?php


namespace App\Modules\ProjectType\Actions;

use App\Modules\ProjectType\DTO\ProjectTypeDTO;
use App\Modules\ProjectType\Models\ProjectType;

class StoreProjectTypeAction
{

  public static function execute(ProjectTypeDTO $projectTypeDTO)
  {
    $projectType = new ProjectType($projectTypeDTO->toArray());
    $projectType->save();
    return $projectType;
  }
}
