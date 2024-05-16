<?php

namespace App\Modules\Party\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Party\Actions\DeletePartyByElectionAction;
use App\Modules\Party\Actions\StorePartyAction;
use App\Modules\Party\Actions\DeletePartyAction;
use App\Modules\Party\Actions\UpdatePartyAction;
use App\Modules\Party\DTO\PartyDTO;
use App\Modules\Party\Models\Party;
use App\Modules\Party\Requests\StorePartyRequest;
use App\Modules\Party\Requests\UpdatePartyRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PartyDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Party::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('color', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }

                if (isset(request('filter')['color'])) {
                    $query->where('color', 'like', "%" . request('filter')['color'] . "%");
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function indexByElection(Request $request, Election $election)
    {
        $response = Helper::createSuccessResponse($election->parties, '');
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartyRequest $storePartyRequest)
    {
        $partyDTO = PartyDTO::fromRequest($storePartyRequest);
        $party = Party::where('name', $storePartyRequest->name)->first();
        if (!$party) {
            $party = StorePartyAction::execute($partyDTO);
        }
        if ($storePartyRequest->election) {
            $election = Election::find($storePartyRequest->election);
            $maxOrder = DB::table('elections_vs_parties')->where('election_id', $election->id)->max('order');
            $election->parties()->attach([$party->id => ['color' => $storePartyRequest->color, 'order' => $maxOrder + 1]]);
        }
        Helper::createSuccessResponse($party);
        return response()->json(['message' => 'New Party Added Successfully!'], 200);
    }

    public function reorderElectionParties(Election $election, Request $request)
    {
        $data = $request->only(['ids']);
        foreach ($data['ids'] as $index => $partyId) {
            DB::table('elections_vs_parties')->where('party_id', $partyId)->where('election_id', $election->id)->update(['order' => $index]);
        }
        return response()->json(['message' => 'sorted successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartyRequest $updatePartyRequest, Party $party)
    {
        $partyDTO = PartyDTO::fromRequestForUpdate($updatePartyRequest, $party);
        Helper::createSuccessResponse(UpdatePartyAction::execute($party, $partyDTO));
        return response()->json(['message' => 'Party Edited Successfully!'], 200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Party $Party
     * @param Election $election
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyByElection(Party $party, Election $election)
    {
        //
        DeletePartyByElectionAction::execute($party, $election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
