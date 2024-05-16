<?php

namespace App\Modules\ProjectType\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\ProjectType\Actions\StoreProjectTypeAction;
use App\Modules\ProjectType\Actions\DeleteProjectTypeAction;
use App\Modules\ProjectType\Actions\UpdateProjectTypeAction;
use App\Modules\ProjectType\DTO\ProjectTypeDTO;
use App\Modules\ProjectType\Models\ProjectType;
use App\Modules\ProjectType\Requests\StoreProjectTypeRequest;
use App\Modules\ProjectType\Requests\UpdateProjectTypeRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectTypeDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ProjectType::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('name') . "%");
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
    public function store(StoreProjectTypeRequest $storeProjectTypeRequest)
    {
        $projectTypeDTO = ProjectTypeDTO::fromRequest($storeProjectTypeRequest);
        $projectType = StoreProjectTypeAction::execute($projectTypeDTO);
        Helper::createSuccessResponse($projectType);
        return response()->json(['message' => 'New ProjectType Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectTypeRequest $updateProjectTypeRequest, ProjectType $projectType)
    {
        $projectTypeDTO = ProjectTypeDTO::fromRequestForUpdate($updateProjectTypeRequest, $projectType);
        Helper::createSuccessResponse(UpdateProjectTypeAction::execute($projectType, $projectTypeDTO));
        return response()->json(['message' => 'ProjectType Edited Successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProjectType $ProjectType
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProjectType $projectType)
    {
        //
        DeleteProjectTypeAction::execute($projectType);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
