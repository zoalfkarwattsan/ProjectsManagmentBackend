<?php


namespace App\Modules\Task\Actions;

use App\Modules\Project\Actions\UpdateProjectAction;
use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Task\DTO\TaskDTO;
use App\Modules\Task\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpdateTaskAction
{
    public static function execute(Task $task, TaskDTO $taskDTO, $disable_notification)
    {
        $pastStatus = $task->status_id;
        if ($pastStatus !== $taskDTO->status_id) {
            switch ($taskDTO->status_id) {
                case 3 :
                    $taskDTO->started_date = Carbon::now();
                    break;
                case 2:
                    $taskDTO->completed_date = Carbon::now();
                    break;
            }
        }
        $task->update($taskDTO->toArray());
        $allCompelted = true;
        foreach ($task->project->tasks as $tempTask) {
            if ($tempTask->status_id === 1 || $tempTask->status_id === 3) {
                $allCompelted = false;
            }
        }
        if ($allCompelted) {
            $request = ['status_id' => 2];
            $projectDto = ProjectDTO::fromRequestForUpdate($request, $task->project);
            UpdateProjectAction::execute($task->project, $projectDto, null, true, $disable_notification);
        } else if ($task->project->status_id === 2) {
            $request = ['status_id' => 1];
            $projectDto = ProjectDTO::fromRequestForUpdate($request, $task->project);
            UpdateProjectAction::execute($task->project, $projectDto, null, true, $disable_notification);
        }
        return $task;
    }

}
