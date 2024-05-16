<?php


namespace App\Modules\ProjectType\Actions;

use App\Modules\ProjectType\DTO\ProjectTypeDTO;
use App\Modules\ProjectType\Models\ProjectType;

class UpdateProjectTypeAction
{
  public static function execute(ProjectType $projectType, ProjectTypeDTO $projectTypeDTO)
  {
    $projectType->update($projectTypeDTO->toArray());
    return $projectType;
  }

}
