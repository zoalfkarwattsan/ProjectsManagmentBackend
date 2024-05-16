<?php

namespace App\Modules\Auth\Responsible\Controllers;

use App\Modules\Auth\Responsible\Actions\DeleteResponsibleAction;
use App\Modules\Auth\Responsible\Actions\StoreResponsibleAction;
use App\Modules\Auth\Responsible\Actions\UpdateResponsibleAction;
use App\Modules\Auth\Responsible\DTO\ResponsibleDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Auth\Responsible\Requests\StoreResponsibleRequest;
use App\Modules\Auth\Responsible\Requests\UpdateResponsibleRequest;
use App\Modules\Auth\Responsible\ViewModels\ResponsibleIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Auth\Responsible\ViewModels\ResponsibleShowVM;

class ResponsibleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(ResponsibleIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreResponsibleRequest $createResponsibleRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreResponsibleRequest $createResponsibleRequest)
  {
    //
    $ResponsibleDTO = ResponsibleDTO::fromRequest($createResponsibleRequest);
    $response = Helper::createSuccessResponse(StoreResponsibleAction::execute($ResponsibleDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Responsible $Responsible
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Responsible $responsible)
  {
    //
    $response = Helper::createSuccessResponse(ResponsibleShowVM::toArray($responsible));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateResponsibleRequest $updateResponsibleRequest
   * @param Responsible $Responsible
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateResponsibleRequest $updateResponsibleRequest, Responsible $user)
  {
    //
    $userDTO = ResponsibleDTO::fromRequestForUpdate($updateResponsibleRequest, $user);
    $response = Helper::createSuccessResponse(ResponsibleShowVM::toArray(UpdateResponsibleAction::execute($user, $userDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Responsible $Responsible
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Responsible $user)
  {
    //
    DeleteResponsibleAction::execute($user);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
