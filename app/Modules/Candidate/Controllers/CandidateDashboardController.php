<?php

namespace App\Modules\Candidate\Controllers;

use App\Modules\Candidate\Actions\StoreCandidateAction;
use App\Modules\Candidate\Actions\DeleteCandidateAction;
use App\Modules\Candidate\Actions\UpdateCandidateAction;
use App\Modules\Candidate\DTO\CandidateDTO;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Candidate\Requests\StoreCandidateRequest;
use App\Modules\Candidate\Requests\UpdateCandidateRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Election\Models\Election;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CandidateDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Candidate::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('year', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('candidate_date', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['year'])) {
                    $query->where('year', 'like', "%" . request('year') . "%");
                }

                if (isset(request('filter')['candidate_date'])) {
                    $query->where('candidate_date', 'like', "%" . request('candidate_date') . "%");
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function indexListByElection(Request $request, Election $election)
    {

        $data = Candidate::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($election) {
                $query->where('election_id', '=', $election->id);
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mother_name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('gender', 'like', "%" . request('search')['value'] . "%")
//              ->orWhere('birth_date', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('civil_registration', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('record_religion', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('personal_religion', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['fname'])) {
                    $query->where('fname', 'like', "%" . request('filter')['fname'] . "%");
                }

                if (isset(request('filter')['mname'])) {
                    $query->where('mname', 'like', "%" . request('filter')['mname'] . "%");
                }

                if (isset(request('filter')['lname'])) {
                    $query->where('lname', 'like', "%" . request('filter')['lname'] . "%");
                }

                if (isset(request('filter')['mother_name'])) {
                    $query->where('mother_name', 'like', "%" . request('filter')['mother_name'] . "%");
                }

                if (isset(request('filter')['gender'])) {
                    $query->where('gender', 'like', "%" . request('filter')['gender'] . "%");
                }

                if (isset(request('filter')['civil_registration'])) {
                    $query->where('civil_registration', 'like', "%" . request('filter')['civil_registration'] . "%");
                }

                if (isset(request('filter')['record_religion'])) {
                    $query->where('record_religion', 'like', "%" . request('filter')['record_religion'] . "%");
                }

                if (isset(request('filter')['personal_religion'])) {
                    $query->where('personal_religion', 'like', "%" . request('filter')['personal_religion'] . "%");
                }

                if (isset(request('filter')['birth_date']) && strlen(request('filter')['birth_date']) > 0) {
                    $query->where('birth_date', 'like', "%" . request('filter')['birth_date'] . "%");
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
    public function store(StoreCandidateRequest $storeCandidateRequest)
    {
        $candidateDTO = CandidateDTO::fromRequest($storeCandidateRequest);
        Helper::createSuccessResponse(StoreCandidateAction::execute($candidateDTO));
        return response()->json(['message' => 'New Candidate Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidateRequest $updateCandidateRequest, Candidate $candidate)
    {
        $candidateDTO = CandidateDTO::fromRequestForUpdate($updateCandidateRequest, $candidate);
        Helper::createSuccessResponse(UpdateCandidateAction::execute($candidate, $candidateDTO));
        return response()->json(['message' => 'Candidate Edited Successfully!'], 200);
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
