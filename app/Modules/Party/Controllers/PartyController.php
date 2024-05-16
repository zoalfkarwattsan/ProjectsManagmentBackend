<?php

namespace App\Modules\Party\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Party\Actions\StorePartyAction;
use App\Modules\Party\Actions\DeletePartyAction;
use App\Modules\Party\Actions\UpdatePartyAction;
use App\Modules\Party\DTO\PartyDTO;
use App\Modules\Party\Models\Party;
use App\Modules\Party\Requests\StorePartyRequest;
use App\Modules\Party\Requests\UpdatePartyRequest;
use App\Modules\Party\ViewModels\PartyIndexByActiveElectionVM;
use App\Modules\Party\ViewModels\PartyIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Party\ViewModels\PartyShowVM;
use Carbon\Carbon;

class PartyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(PartyIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Display a listing of the resource by Active Election
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function activeParties()
  {
    $response = Helper::createSuccessResponse(PartyIndexByActiveElectionVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StorePartyRequest $createPartyRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StorePartyRequest $createPartyRequest)
  {
    //
    $PartyDTO = PartyDTO::fromRequest($createPartyRequest);
    $response = Helper::createSuccessResponse(StorePartyAction::execute($PartyDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Party $Party
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Party $party)
  {
    //
    $response = Helper::createSuccessResponse(PartyShowVM::toArray($party));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdatePartyRequest $updatePartyRequest
   * @param Party $Party
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdatePartyRequest $updatePartyRequest, Party $party)
  {
    //
    $partyDTO = PartyDTO::fromRequestForUpdate($updatePartyRequest, $party);
    $response = Helper::createSuccessResponse(PartyShowVM::toArray(UpdatePartyAction::execute($party, $partyDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Party $Party
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Party $party)
  {
    //
    DeletePartyAction::execute($party);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
