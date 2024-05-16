<?php

namespace App\Modules\Project\Controllers;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Actions\StoreProjectAction;
use App\Modules\Project\Actions\DeleteProjectAction;
use App\Modules\Project\Actions\UpdateProjectAction;
use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Project\Models\Project;
use App\Modules\Project\Requests\StoreProjectRequest;
use App\Modules\Project\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Project\ViewModels\ProjectShowVM;
use App\Modules\ProjectType\Models\ProjectType;
use App\Modules\ProjectVsResponsible\DTO\ProjectVsResponsibleCollection;
use App\Modules\Status\Models\Status;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use function PHPUnit\Framework\returnArgument;

class ProjectDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request);
        $data = Project::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('start_date', function ($row) {
                return $row->start_date ? date('d/m/Y', strtotime($row->start_date)) : null;
            })
            ->editColumn('due_date', function ($row) {
                return $row->due_date ? date('d/m/Y', strtotime($row->due_date)) : null;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }
                if (isset(request('filter')['type']) && request('filter')['type'] > 0) {
                    $query->where('project_type_id', '=', request('filter')['type']);
                }
                if (isset(request('filter')['user_id']) && request('filter')['user_id'] > 0) {
                    $query->where('user_id', '=', request('filter')['user_id']);
                }
                if (isset(request('filter')['status']) && request('filter')['status'] > 0) {
                    $query->whereIn('status_id', request('filter')['status']);
                }
                if (isset(request('filter')['from_date']) && isset(request('filter')['to_date']) && request('filter')['from_date'] > 0 && request('filter')['to_date'] > 0) {
                    $query->whereBetween('start_date', [request('filter')['from_date'], request('filter')['to_date']])
                        ->orWhereBetween('due_date', [request('filter')['from_date'], request('filter')['to_date']]);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource for specific resonsible
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByResponsible(Request $request, Responsible $responsible)
    {
        $data = Project::select('*')->whereIn('id', $responsible->projects->pluck('id'));
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('start_date', function ($row) {
                return date('d/m/Y', strtotime($row->start_date));
            })
            ->editColumn('due_date', function ($row) {
                return date('d/m/Y', strtotime($row->due_date));
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('name') . "%");
                }
                if (isset(request('filter')['type']) && request('type') > 0) {
                    $query->where('project_type_id', '=', request('type'));
                }
                if (isset(request('filter')['user_id']) && request('user_id') > 0) {
                    $query->where('user_id', '=', request('user_id'));
                }
                if (isset(request('filter')['status']) && request('status') > 0) {
                    $query->where('status_id', '=', request('status'));
                }
                if (isset(request('filter')['from_date']) && isset(request('filter')['to_date']) && request('from_date') > 0 && request('to_date') > 0) {
                    $query->whereBetween('start_date', [request('from_date'), request('to_date')])
                        ->orWhereBetween('due_date', [request('from_date'), request('to_date')]);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource for specific resonsible
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByUser(Request $request, User $user)
    {
        $data = Project::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('start_date', function ($row) {
                return date('d/m/Y', strtotime($row->start_date));
            })
            ->editColumn('due_date', function ($row) {
                return date('d/m/Y', strtotime($row->due_date));
            })
            ->filter(function ($query) use ($user) {
                $query->where('user_id', $user->id);
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }
                if (isset(request('filter')['type']) && request('filter')['type'] > 0) {
                    $query->where('project_type_id', '=', request('filter')['type']);
                }
                if (isset(request('filter')['user_id']) && request('filter')['user_id'] > 0) {
                    $query->where('user_id', '=', request('filter')['user_id']);
                }
                if (isset(request('filter')['status']) && request('filter')['status'] > 0) {
                    $query->whereIn('status_id', request('filter')['status']);
                }
                if (isset(request('filter')['from_date']) && isset(request('filter')['to_date']) && request('filter')['from_date'] > 0 && request('filter')['to_date'] > 0) {
                    $query->whereBetween('start_date', [request('filter')['from_date'], request('filter')['to_date']])
                        ->orWhereBetween('due_date', [request('filter')['from_date'], request('filter')['to_date']]);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function getAllProjectTypesWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(
            [
                'projecttypes' => ProjectType::where('name', 'like', '%' . $request->q . '%')->limit(request('limit'))->get()
            ],
            ''
        );
        return response()->json($response, 200);
    }

    public function getAllStatusesWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(
            [
                'statuses' => Status::where('name', 'like', '%' . $request->q . '%')->limit(request('limit'))->get()
            ],
            ''
        );
        return response()->json($response, 200);
    }

    public function indexQProjects(Request $request)
    {
        $projects = Project::where('name', 'like', '%' . $request->q . '%')->whereNull('user_id')->paginate(10);
        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $storeProjectRequest)
    {
        $projectDTO = ProjectDTO::fromRequest($storeProjectRequest);
        $projectVsResponsibleCollection = ProjectVsResponsibleCollection
            ::fromRequest($storeProjectRequest);
        $response = Helper
            ::createSuccessResponse(StoreProjectAction::execute($projectDTO, $projectVsResponsibleCollection, $storeProjectRequest->disable_notification));
        return response()->json(['message' => 'New Project Added Successfully!'], 200);
    }

    public function edit(Project $project)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $updateProjectRequest, Project $project)
    {
        $projectDTO = ProjectDTO::fromRequestForUpdate($updateProjectRequest, $project);
        $projectVsResponsibleCollection = ProjectVsResponsibleCollection
            ::fromRequest($updateProjectRequest);
        $response = Helper
            ::createSuccessResponse(UpdateProjectAction::execute($project, $projectDTO, $projectVsResponsibleCollection, false, $updateProjectRequest->disable_notification));
        return response()->json(['message' => 'Project Edited Successfully!'], 200);
    }

    public function show(Project $project)
    {
        $response = Helper::createSuccessResponse($project, '');
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $Project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        //
        try {
            $project->tasks()->delete();
            DeleteProjectAction::execute($project);
            return response()->json(['O_Msg' => 'Item Deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Please remove citizen and all responsibles from project'], 500);
        }
    }

}
