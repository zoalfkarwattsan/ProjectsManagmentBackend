<?php


namespace App\Modules\Project\Actions;

use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Project\Models\Project;
use App\Modules\ProjectVsResponsible\Actions\StoreProjectVsResponsibleAction;

class UpdateProjectAction
{
    public static function execute(Project $project, ProjectDTO $projectDTO, $projectVsResponsibleCollection, $taskUpdate, $disable_notification = false)
    {
        $project->update($projectDTO->toArray());
        if (!$taskUpdate) {
            if ($projectVsResponsibleCollection && count($projectVsResponsibleCollection->toArr()) > 0) {
                StoreProjectVsResponsibleAction::execute($project, $projectVsResponsibleCollection, $disable_notification);
            } else {
                $project->responsibles()->sync([]);
            }
        }
        return $project;
    }
}
