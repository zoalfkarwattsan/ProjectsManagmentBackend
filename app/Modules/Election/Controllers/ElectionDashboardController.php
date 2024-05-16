<?php

namespace App\Modules\Election\Controllers;

use App\Modules\Box\ViewModels\BoxSpecificIndexVM;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Actions\ActivateElectionAction;
use App\Modules\Election\Actions\DeActivateElectionAction;
use App\Modules\Election\Actions\ResetElectionAction;
use App\Modules\Election\Actions\StoreElectionAction;
use App\Modules\Election\Actions\DeleteElectionAction;
use App\Modules\Election\Actions\UpdateElectionAction;
use App\Modules\Election\DTO\ElectionDTO;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\ElectionExport;
use App\Modules\Election\Requests\StoreElectionRequest;
use App\Modules\Election\Requests\UpdateElectionRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ElectionDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Election::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('year', function ($row) {
                return $row->year;
            })
            ->editColumn('election_date', function ($row) {
                return $row->election_date;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('year', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('election_date', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['year'])) {
                    $query->where('year', 'like', "%" . request('filter')['year'] . "%");
                }

                if (isset(request('filter')['election_date'])) {
                    $query->where('election_date', 'like', "%" . request('filter')['election_date'] . "%");
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexListPrevElections(Request $request, User $user)
    {
        $data = Election::select('*');
        $data = Datatables::of($data)
            ->editColumn('user', function ($row) use ($user) {
                return $row->users()->wherePivot('user_id', $user->id)->first();
            })
            ->filter(function ($query) use ($user) {
                $query->whereIn('id', $user->elections->pluck('id'));
                if (isset(request('search')['value'])) {
                    $query->where('year', 'like', "%" . request('search')['value'] . "%");
                }

                if (isset(request('filter')['year'])) {
                    $query->where('year', 'like', "%" . request('year') . "%");
                }

                if (isset(request('filter')['voted']) && request('filter')['voted'] > -1) {
                    $query->whereIn('id', $user->elections()->wherePivot('voted', request('filter')['voted'])->get()->pluck('id'));
                }

                if (isset(request('filter')['arrived']) && request('filter')['arrived'] > -1) {
                    $query->whereIn('id', $user->elections()->wherePivot('arrived', request('filter')['arrived'])->get()->pluck('id'));
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function getActiveElectionLiveStream()
    {
        $election = Election::where('active', 1)->first();
        if ($election) {
            $data = DB::table('elections_vs_users')
                ->select('color', 'voted', 'arrived')
                ->where('election_id', $election->id)
                ->where('outdoor', 0)
                ->get();
            $data = [
                'total_voters' => count($data),
                'total_voted' => count($data->filter(function ($item) {
                    return $item->voted > 0;
                })),
                'total_black' => count($data->filter(function ($item) {
                    return $item->color === 'black';
                })),
                'voted_black' => count($data->filter(function ($item) {
                    return $item->color === 'black' && $item->voted > 0;
                })),
                'total_grey' => count($data->filter(function ($item) {
                    return $item->color === 'grey';
                })),
                'voted_grey' => count($data->filter(function ($item) {
                    return $item->color === 'grey' && $item->voted > 0;
                })),
                'total_white' => count($data->filter(function ($item) {
                    return $item->color === 'white';
                })),
                'voted_white' => count($data->filter(function ($item) {
                    return $item->color === 'white' && $item->voted > 0;
                })),
                'cancelled_votes' => $election->boxes->sum(function ($box) {
                    return $box->cancelled;
                }),
                'white_papers' => $election->boxes->sum(function ($box) {
                    return $box->white_paper;
                }),
                'parties' => $election->parties->map(function ($party) use ($election) {
                    return [
                        'id' => $party->id,
                        'name' => $party->name,
                        'votes_num' => DB::table('boxes_vs_parties')
                            ->where('party_id', $party->id)
                            ->whereIn('box_id', $election->boxes->pluck('id'))
                            ->get()->sum(function ($item) {
                                return $item->votes_num;
                            }),
                        'candidates' => Candidate::where('election_id', $election->id)
                            ->where('party_id', $party->id)
                            ->get()->map(function ($candidate) {
                                return [
                                    'id' => $candidate->id,
                                    'name' => $candidate->fname . ' ' . $candidate->mname . ' ' . $candidate->lname,
                                    'image' => $candidate->image,
                                    'votes_num' => $candidate->boxes->sum(function ($item) {
                                        return $item->pivot->votes_num;
                                    })
                                ];
                            })
                    ];
                })
            ];
            $data = Helper::createSuccessResponse($data, '');
            return response()->json($data, 200);
        } else {
            $data = Helper::createFailResponse('No Active Election');
            return response()->json($data, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreElectionRequest $storeElectionRequest)
    {
        $electionDTO = ElectionDTO::fromRequest($storeElectionRequest);
        Helper::createSuccessResponse(StoreElectionAction::execute($electionDTO));
        return response()->json(['message' => 'New Election Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateElectionRequest $updateElectionRequest, Election $election)
    {
        $electionDTO = ElectionDTO::fromRequestForUpdate($updateElectionRequest, $election);
        Helper::createSuccessResponse(UpdateElectionAction::execute($election, $electionDTO));
        return response()->json(['message' => 'Election Edited Successfully!'], 200);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Election $Election
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Election $election)
    {
        //
        ActivateElectionAction::execute($election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    public function deactivate(Election $election)
    {
        //
        DeActivateElectionAction::execute($election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    public function reset(Election $election)
    {
        //
        ResetElectionAction::execute($election);
        return response()->json(['O_Msg' => ''], 200);
    }

    public function export()
    {
        set_time_limit(0);
        return Excel::download(new ElectionExport, 'statistics.xlsx');
    }

}
