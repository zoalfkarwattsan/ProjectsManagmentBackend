<?php


namespace App\Modules\Project\Actions;

use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Project\Models\Project;
use App\Modules\ProjectVsResponsible\Actions\StoreProjectVsResponsibleAction;
use Illuminate\Support\Facades\Auth;

class StoreProjectAction
{

  public static function execute(ProjectDTO $projectDTO, $projectVsResponsibleCollection, $disable_notification = false)
  {
    $created_by_user_id = Auth::guard('web')->id();
    $project = new Project($projectDTO->toArray());
    $project->save();
    if ($projectVsResponsibleCollection && count($projectVsResponsibleCollection->toArr()) > 0) {
      StoreProjectVsResponsibleAction::execute($project, $projectVsResponsibleCollection, $disable_notification);
    }
    return $project;
  }
}
