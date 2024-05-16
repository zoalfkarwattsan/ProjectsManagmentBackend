<?php

namespace App\Modules\Election\Controllers;

use App\Modules\Election\Actions\StoreElectionAction;
use App\Modules\Election\Actions\DeleteElectionAction;
use App\Modules\Election\Actions\SyncOfflineAction;
use App\Modules\Election\Actions\UpdateElectionAction;
use App\Modules\Election\DTO\ElectionDTO;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Requests\StoreElectionRequest;
use App\Modules\Election\Requests\UpdateElectionRequest;
use App\Modules\Election\ViewModels\ElectionIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Election\ViewModels\ElectionShowVM;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(ElectionIndexVM::toArray());
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StoreElectionRequest $createElectionRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreElectionRequest $createElectionRequest)
    {
        //
        $ElectionDTO = ElectionDTO::fromRequest($createElectionRequest);
        $response = Helper::createSuccessResponse(StoreElectionAction::execute($ElectionDTO));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Election $Election
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Election $election)
    {
        //
        $response = Helper::createSuccessResponse(ElectionShowVM::toArray($election));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateElectionRequest $updateElectionRequest
     * @param Election $Election
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateElectionRequest $updateElectionRequest, Election $election)
    {
        //
        $electionDTO = ElectionDTO::fromRequestForUpdate($updateElectionRequest, $election);
        $response = Helper::createSuccessResponse(ElectionShowVM::toArray(UpdateElectionAction::execute($election, $electionDTO)));
        return response()->json($response, 200);
    }

    public function syncOfflineElection(Request $request)
    {
        //
        $response = Helper::createSuccessResponse(SyncOfflineAction::execute($request));
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Election $Election
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Election $election)
    {
        //
        DeleteElectionAction::execute($election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }
}
