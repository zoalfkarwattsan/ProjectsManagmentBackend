<?php

namespace App\Modules\Project\Controllers;

use App\Modules\Project\Actions\StoreProjectAction;
use App\Modules\Project\Actions\DeleteProjectAction;
use App\Modules\Project\Actions\UpdateProjectAction;
use App\Modules\Project\DTO\ProjectDTO;
use App\Modules\Project\Models\Project;
use App\Modules\Project\Requests\StoreProjectRequest;
use App\Modules\Project\Requests\UpdateProjectRequest;
use App\Modules\Project\ViewModels\ProjectIndexByAuthResponsibleVM;
use App\Modules\Project\ViewModels\ProjectIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Project\ViewModels\ProjectShowVM;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(ProjectIndexVM::toArray());
    return response()->json($response, 200);
  }
  /**
   * Display a listing of the resource for Auth Responsible
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function indexByAuthResponsible()
  {
    $response = Helper::createSuccessResponse(ProjectIndexByAuthResponsibleVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreProjectRequest $createUserRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreProjectRequest $storeProjectRequest)
  {
    //
    $projectDTO = ProjectDTO::fromRequest($storeProjectRequest);
    $response = Helper::createSuccessResponse(StoreProjectAction::execute($projectDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Project $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Project $project)
  {
    //
    $response = Helper::createSuccessResponse(ProjectShowVM::toArray($project));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateProjectRequest $updateUserRequest
   * @param Project $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateProjectRequest $updateUserRequest, Project $project)
  {
    //
    $projectDTO = ProjectDTO::fromRequestForUpdate($updateUserRequest, $project);
    $response = Helper::createSuccessResponse(ProjectShowVM::toArray(UpdateProjectAction::execute($project, $projectDTO, null, true, false)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Project $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Project $project)
  {
    //
    DeleteProjectAction::execute($project);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
