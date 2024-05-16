<?php

namespace App\Modules\Task\Controllers;

use App\Modules\Auth\Notification\Actions\StoreNotificationAction;
use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Models\Project;
use App\Modules\Task\Actions\StoreTaskAction;
use App\Modules\Task\Actions\DeleteTaskAction;
use App\Modules\Task\Actions\UpdateTaskAction;
use App\Modules\Task\DTO\TaskDTO;
use App\Modules\Task\Models\Task;
use App\Modules\Task\Requests\StoreTaskRequest;
use App\Modules\Task\Requests\UpdateTaskRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageConfigs = ['pageHeader' => true];
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"], ["name" => "Tasks"]
        ];

        $data = Task::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('user', function ($row) {
                return $row->user->first_name . ' ' . $row->user->last_name;
            })
            ->editColumn('status', function ($row) {
                return "<div class='badge badge-pill  badge-" . $row->status->icon_color . " mr-1 mb-1'>" . $row->status->name . "</div>";
            })
            ->editColumn('type', function ($row) {
                return $row->project_type->name;
            })
            ->rawColumns(['user', 'status', 'type'])
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('description', 'like', "%" . request('search')['value'] . "%");
                }

                if (isset(request('filter')['description'])) {
                    $query->where('description', 'like', "%" . request('description') . "%");
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
        $data = ['columns' => [
            //['data' => 'id', 'name' => 'ID'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'description', 'name' => 'description'],
            ['data' => 'due_date', 'name' => 'due_date'],
            ['data' => 'user', 'name' => 'user'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'actions', 'name' => 'Actions', 'orderable' => false, 'searchable' => false],
        ], 'title' => 'Tasks List', 'subtitle' => 'This is the list of our tasks', 'url' => route('tasks.index')
        ];
    }

    /**
     * Display a listing of the resource for specific project.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByProject(Request $request, Project $project)
    {

        $data = Task::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($project) {
                $query->where('project_id', '=', $project->id);
                if (isset(request('search')['value'])) {
                    $query->where('description', 'like', "%" . request('search')['value'] . "%")
                        ->where('name', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }
                if (isset(request('filter')['description'])) {
                    $query->where('description', 'like', "%" . request('filter')['description'] . "%");
                }
                if (isset(request('filter')['status']) && request('filter')['status'] > 0) {
                    $query->where('status_id', '=', request('filter')['status']);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $storeTaskRequest)
    {
        $taskDTO = TaskDTO::fromRequest($storeTaskRequest);
        $response = Helper::createSuccessResponse(StoreTaskAction::execute($taskDTO, $storeTaskRequest->disable_notification));
//        $responsible = Responsible::find($taskDTO->responsible_id);
        return response()->json(['message' => 'New Task Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $updateTaskRequest, Task $task)
    {
        $taskDTO = TaskDTO::fromRequestForUpdate($updateTaskRequest, $task);
        Helper::createSuccessResponse(UpdateTaskAction::execute($task, $taskDTO, $updateTaskRequest->disable_notification));
        $responsible = Responsible::find($taskDTO->responsible_id);
        if ($responsible && $updateTaskRequest->disable_notification) {
            StoreNotificationAction::execute(new NotificationDTO([
                'title' => 'Task',
                'body' => $task->responsible_id === $taskDTO->responsible_id ? 'Old Task Has been updated' : 'You Have Been assigned to new task',
                'responsibles' => [$responsible->fcm_token],
            ]));
        }
        return response()->json(['message' => 'Task Edited Successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $Task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        //
        DeleteTaskAction::execute($task);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
