<?php

namespace App\Modules\Municipality\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Municipality\Actions\StoreMunicipalityAction;
use App\Modules\Municipality\Actions\DeleteMunicipalityAction;
use App\Modules\Municipality\Actions\UpdateMunicipalityAction;
use App\Modules\Municipality\DTO\MunicipalityDTO;
use App\Modules\Municipality\Models\Municipality;
use App\Modules\Municipality\Requests\StoreMunicipalityRequest;
use App\Modules\Municipality\Requests\UpdateMunicipalityRequest;
use App\Modules\Municipality\ViewModels\MunicipalityIndexByActiveElectionVM;
use App\Modules\Municipality\ViewModels\MunicipalityIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Municipality\ViewModels\MunicipalityShowVM;
use Carbon\Carbon;

class MunicipalityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(MunicipalityIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Display a listing of the resource by Active Election
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function activeMunicipalities()
  {
    $response = Helper::createSuccessResponse(MunicipalityIndexByActiveElectionVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreMunicipalityRequest $createMunicipalityRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreMunicipalityRequest $createMunicipalityRequest)
  {
    //
    $MunicipalityDTO = MunicipalityDTO::fromRequest($createMunicipalityRequest);
    $response = Helper::createSuccessResponse(StoreMunicipalityAction::execute($MunicipalityDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Municipality $Municipality
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Municipality $municipality)
  {
    //
    $response = Helper::createSuccessResponse(MunicipalityShowVM::toArray($municipality));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateMunicipalityRequest $updateMunicipalityRequest
   * @param Municipality $Municipality
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateMunicipalityRequest $updateMunicipalityRequest, Municipality $municipality)
  {
    //
    $municipalityDTO = MunicipalityDTO::fromRequestForUpdate($updateMunicipalityRequest, $municipality);
    $response = Helper::createSuccessResponse(MunicipalityShowVM::toArray(UpdateMunicipalityAction::execute($municipality, $municipalityDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Municipality $Municipality
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Municipality $municipality)
  {
    //
    DeleteMunicipalityAction::execute($municipality);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
