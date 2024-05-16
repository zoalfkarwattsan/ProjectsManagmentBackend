<?php

namespace App\Modules\Candidate\Controllers;

use App\Modules\Candidate\Actions\StoreCandidateAction;
use App\Modules\Candidate\Actions\DeleteCandidateAction;
use App\Modules\Candidate\Actions\UpdateCandidateAction;
use App\Modules\Candidate\DTO\CandidateDTO;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Candidate\Requests\StoreCandidateRequest;
use App\Modules\Candidate\Requests\UpdateCandidateRequest;
use App\Modules\Candidate\ViewModels\CandidateIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Candidate\ViewModels\CandidateShowVM;

class CandidateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(CandidateIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreCandidateRequest $createCandidateRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreCandidateRequest $createCandidateRequest)
  {
    //
    $CandidateDTO = CandidateDTO::fromRequest($createCandidateRequest);
    $response = Helper::createSuccessResponse(StoreCandidateAction::execute($CandidateDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Candidate $Candidate
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Candidate $candidate)
  {
    //
    $response = Helper::createSuccessResponse(CandidateShowVM::toArray($candidate));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateCandidateRequest $updateCandidateRequest
   * @param Candidate $Candidate
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateCandidateRequest $updateCandidateRequest, Candidate $candidate)
  {
    //
    $candidateDTO = CandidateDTO::fromRequestForUpdate($updateCandidateRequest, $candidate);
    $response = Helper::createSuccessResponse(CandidateShowVM::toArray(UpdateCandidateAction::execute($candidate, $candidateDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Candidate $Candidate
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Candidate $candidate)
  {
    //
    DeleteCandidateAction::execute($candidate);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
