<?php

namespace App\Modules\Status\Controllers;

use App\Modules\Status\Actions\StoreStatusAction;
use App\Modules\Status\Actions\DeleteStatusAction;
use App\Modules\Status\Actions\UpdateStatusAction;
use App\Modules\Status\DTO\StatusDTO;
use App\Modules\Status\Models\Status;
use App\Modules\Status\Requests\StoreStatusRequest;
use App\Modules\Status\Requests\UpdateStatusRequest;
use App\Modules\Status\ViewModels\StatusIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Status\ViewModels\StatusShowVM;

class StatusController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(StatusIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreStatusRequest $createStatusRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreStatusRequest $createStatusRequest)
  {
    //
    $statusDTO = StatusDTO::fromRequest($createStatusRequest);
    $response = Helper::createSuccessResponse(StoreStatusAction::execute($statusDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Status $status
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Status $status)
  {
    //
    $response = Helper::createSuccessResponse(StatusShowVM::toArray($status));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateStatusRequest $updateStatusRequest
   * @param Status $status
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateStatusRequest $updateStatusRequest, Status $status)
  {
    //
    $statusDTO = StatusDTO::fromRequestForUpdate($updateStatusRequest, $status);
    $response = Helper::createSuccessResponse(StatusShowVM::toArray(UpdateStatusAction::execute($status, $statusDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Status $status
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Status $status)
  {
    //
    DeleteStatusAction::execute($status);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
