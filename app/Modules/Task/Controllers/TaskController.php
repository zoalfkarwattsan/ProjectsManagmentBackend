<?php

namespace App\Modules\Task\Controllers;

use App\Modules\Auth\Notification\Actions\StoreNotificationAction;
use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Models\Project;
use App\Modules\Project\ViewModels\ProjectIndexByAuthResponsibleVM;
use App\Modules\Task\Actions\StoreTaskAction;
use App\Modules\Task\Actions\DeleteTaskAction;
use App\Modules\Task\Actions\UpdateTaskAction;
use App\Modules\Task\DTO\TaskDTO;
use App\Modules\Task\Models\Task;
use App\Modules\Task\Requests\StoreTaskRequest;
use App\Modules\Task\Requests\UpdateTaskRequest;
use App\Modules\Task\ViewModels\TaskIndexByProjectVM;
use App\Modules\Task\ViewModels\TaskIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Task\ViewModels\TaskShowVM;
use Illuminate\Support\Facades\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(TaskIndexVM::toArray());
        return response()->json($response, 200);
    }

    public function indexByProject(Project $project)
    {
        $response = Helper::createSuccessResponse(TaskIndexByProjectVM::toArray($project));
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StoreTaskRequest $createUserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $storeTaskRequest)
    {
        //
        $taskDTO = TaskDTO::fromRequest($storeTaskRequest);
        $response = Helper::createSuccessResponse(StoreTaskAction::execute($taskDTO));
        $responsible = Responsible::find($taskDTO->responsible_id);
        StoreNotificationAction::execute(new NotificationDTO([
            'title' => 'Task',
            'body' => 'You Have Been assigned to new task',
            'responsibles' => [$responsible->fcm_token],
        ]));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Task $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        //
        $response = Helper::createSuccessResponse(TaskShowVM::toArray($task));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $updateUserRequest
     * @param Task $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $updateUserRequest, Task $task)
    {
        //
        $taskDTO = TaskDTO::fromRequestForUpdate($updateUserRequest, $task);
        $response = Helper::createSuccessResponse(TaskShowVM::toArray(UpdateTaskAction::execute($task, $taskDTO, $updateUserRequest->disable_notification)));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $updateUserRequest
     * @param Task $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(UpdateTaskRequest $updateUserRequest, Task $task)
    {
        //
        $taskDTO = TaskDTO::fromRequestForUpdate($updateUserRequest, $task);
        TaskShowVM::toArray(UpdateTaskAction::execute($task, $taskDTO, $updateUserRequest->disable_notification));
        $response = Helper::createSuccessResponse(ProjectIndexByAuthResponsibleVM::toArray());
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        //
        DeleteTaskAction::execute($task);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }
}
