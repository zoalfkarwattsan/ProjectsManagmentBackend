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
use App\Modules\ProjectType\ViewModels\ProjectTypeIndexByActiveElectionVM;
use App\Modules\ProjectType\ViewModels\ProjectTypeIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\ProjectType\ViewModels\ProjectTypeShowVM;
use Carbon\Carbon;

class ProjectTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(ProjectTypeIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Display a listing of the resource by Active Election
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function activeProjectTypes()
  {
    $response = Helper::createSuccessResponse(ProjectTypeIndexByActiveElectionVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreProjectTypeRequest $createProjectTypeRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreProjectTypeRequest $createProjectTypeRequest)
  {
    //
    $ProjectTypeDTO = ProjectTypeDTO::fromRequest($createProjectTypeRequest);
    $response = Helper::createSuccessResponse(StoreProjectTypeAction::execute($ProjectTypeDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param ProjectType $ProjectType
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(ProjectType $projectType)
  {
    //
    $response = Helper::createSuccessResponse(ProjectTypeShowVM::toArray($projectType));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateProjectTypeRequest $updateProjectTypeRequest
   * @param ProjectType $ProjectType
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateProjectTypeRequest $updateProjectTypeRequest, ProjectType $projectType)
  {
    //
    $projectTypeDTO = ProjectTypeDTO::fromRequestForUpdate($updateProjectTypeRequest, $projectType);
    $response = Helper::createSuccessResponse(ProjectTypeShowVM::toArray(UpdateProjectTypeAction::execute($projectType, $projectTypeDTO)));
    return response()->json($response, 200);
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
