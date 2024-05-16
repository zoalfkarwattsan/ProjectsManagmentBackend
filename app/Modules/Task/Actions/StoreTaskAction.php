<?php


namespace App\Modules\Task\Actions;

use App\Modules\Project\Actions\UpdateProjectAction;
use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Project\Models\Project;
use App\Modules\Task\DTO\TaskDTO;
use App\Modules\Task\Models\Task;

class StoreTaskAction
{

    public static function execute(TaskDTO $taskDTO, $disable_notification)
    {
        $task = new Task($taskDTO->toArray());
        $task->save();
        if ($task->project->status_id === 2) {
            $request = ['status_id' => 1];
            $projectDto = ProjectDTO::fromRequestForUpdate($request, $task->project);
            UpdateProjectAction::execute($task->project, $projectDto, null, true, $disable_notification);
        }
        return $task;
    }
}
