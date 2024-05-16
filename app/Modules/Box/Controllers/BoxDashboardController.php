<?php

namespace App\Modules\Box\Controllers;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Box\Actions\ResetBoxAction;
use App\Modules\Box\Actions\StoreBoxAction;
use App\Modules\Box\Actions\DeleteBoxAction;
use App\Modules\Box\Actions\UpdateBoxAction;
use App\Modules\Box\Actions\UpdateBoxElectorsAction;
use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Box\Models\Elector;
use App\Modules\Box\Requests\StoreBoxRequest;
use App\Modules\Box\Requests\UpdateBoxRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Box\ViewModels\BoxShowVM;
use App\Modules\Election\Models\Election;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BoxDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Box::select('*');
        $data = Datatables::of($data)
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function indexListByElection(Request $request, Election $election)
    {
        $data = Box::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('election', function ($row) {
                return $row->election->year;
            })
            ->editColumn('municipality', function ($row) {
                return $row->municipality->name;
            })
            ->addColumn('votingProcess', function ($row) {
                return ceil((count($row->users()->wherePivot('voted', 1)->get()) / (count($row->users) ?: 1)) * 100);
            })
            ->addColumn('#OfVoters', function ($row) {
                return count($row->users);
            })
            ->filter(function ($query) use ($election) {
                $query->where('election_id', $election->id);
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }

                if (isset(request('filter')['status'])) {
                    if (request('filter')['status'] === 'pending') {
                        $query->where('is_closed', '=', 0)->where('close_request', 1);
                    } else if (request('filter')['status'] === 'closed') {
                        $query->where('is_closed', '=', 1);
                    } else if (request('filter')['status'] === 'active') {
                        $query->where('is_closed', '=', 0)->where('close_request', 0);
                    }
                }

                if (isset(request('filter')['municipality'])) {
                    $query->whereIn('municipality_id', request('filter')['municipality']);
                }


                if (isset(request('filter')['delegate'])) {
                    if (in_array(-1, request('filter')['delegate'])) {
                        $query->whereNull('delegate_id');
                    } else {
                        $query->whereIn('delegate_id', request('filter')['delegate']);
                    }
                }
//                if (isset(request('filter')['delegate'])) {
//                    $query->whereIn('delegate_id', request('filter')['delegate']);
//                }
            })
            ->toJson();
        $data = Helper::createSuccessDTResponse($data, '');
        return response()->json($data, 200);
    }

    public function indexListByActiveElection(Request $request)
    {
        $election = Election::where('active', 1)->first();
        $data = Box::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('election', function ($row) {
                return $row->election->year;
            })
            ->editColumn('municipality', function ($row) {
                return $row->municipality->name;
            })
            ->addColumn('votingProcess', function ($row) {
                return ceil((count($row->users()->wherePivot('voted', 1)->get()) / (count($row->users) ?: 1)) * 100);
            })
            ->addColumn('#OfVoters', function ($row) {
                return count($row->users);
            })
            ->filter(function ($query) use ($election) {
                if ($election) {
                    $query->where('election_id', $election->id);
                } else {
                    $query->whereNull('election_id');
                }
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }

                if (isset(request('filter')['status'])) {
                    if (request('filter')['status'] === 'pending') {
                        $query->where('is_closed', '=', 0)->where('close_request', 1);
                    } else if (request('filter')['status'] === 'closed') {
                        $query->where('is_closed', '=', 1);
                    } else if (request('filter')['status'] === 'active') {
                        $query->where('is_closed', '=', 0)->where('close_request', 0);
                    }
                }

                if (isset(request('filter')['municipality'])) {
                    $query->whereIn('municipality_id', request('filter')['municipality']);
                }


                if (isset(request('filter')['delegate'])) {
                    if (in_array(-1, request('filter')['delegate'])) {
                        $query->whereNull('delegate_id');
                    } else {
                        $query->whereIn('delegate_id', request('filter')['delegate']);
                    }
                }
//                if (isset(request('filter')['delegate'])) {
//                    $query->whereIn('delegate_id', request('filter')['delegate']);
//                }
            })
            ->toJson();
        $data = Helper::createSuccessDTResponse($data, '');
        return response()->json($data, 200);
    }


    public function indexListForCloseRequests(Request $request, Election $election)
    {
        $data = Box::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('election', function ($row) {
                return $row->election->year;
            })
            ->editColumn('municipality', function ($row) {
                return $row->municipality->name;
            })
            ->addColumn('votingProcess', function ($row) {
                return ceil((count($row->users()->wherePivot('voted', 1)->get()) / (count($row->users) ?: 1)) * 100);
            })
            ->addColumn('#OfVoters', function ($row) {
                return count($row->users);
            })
            ->filter(function ($query) use ($election) {
                $query->where('election_id', $election->id);
                $query->where('close_request', 1);
                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }

                if (isset(request('filter')['status'])) {
                    if (request('filter')['status'] === 'pending') {
                        $query->where('is_closed', '=', 0)->where('close_request', 1);
                    } else if (request('filter')['status'] === 'closed') {
                        $query->where('is_closed', '=', 1);
                    } else if (request('filter')['status'] === 'active') {
                        $query->where('is_closed', '=', 0)->where('close_request', 0);
                    }
                }

                if (isset(request('filter')['municipality'])) {
                    $query->whereIn('municipality_id', request('filter')['municipality']);
                }

                if (isset(request('filter')['delegate'])) {
                    if (in_array(-1, request('filter')['delegate'])) {
                        $query->whereNull('delegate_id');
                    } else {
                        $query->whereIn('delegate_id', request('filter')['delegate']);
                    }
                }
//                if (isset(request('filter')['delegate'])) {
//                    $query->whereIn('delegate_id', request('filter')['delegate']);
//                }
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
    public function store(StoreBoxRequest $storeBoxRequest)
    {
        $boxDTO = BoxDTO::fromRequest($storeBoxRequest);
        $box = StoreBoxAction::execute($boxDTO);
        UpdateBoxElectorsAction::execute($box, $storeBoxRequest->electors, true);
        return response('', 200);
    }

    public function closeBox(Box $box)
    {
        $box->update(['is_closed' => 1]);
        return response()->json(['message' => ''], 200);
    }

    public function openBox(Box $box)
    {
        $box->update(['is_closed' => 0, 'close_request' => 0, 'last_sync_at' => Carbon::now()]);
        return response()->json(['message' => ''], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoxRequest $updateBoxRequest, Box $box)
    {
        $boxDTO = BoxDTO::fromRequestForUpdate($updateBoxRequest, $box);
        $box = UpdateBoxAction::execute($box, $boxDTO);
        UpdateBoxElectorsAction::execute($box, $updateBoxRequest->electors, false);
        return response('', 200);
    }

    public function show(Box $box)
    {
        $data = BoxShowVM::toArray($box);
        $response = Helper::createSuccessResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Box $box)
    {
        //
        DB::table('electors')->where('box_id', '=', $box->id)->delete();
//    DB::table('users')->where('box_id', $box->id)->update(array('box_id' => null));
        DeleteBoxAction::execute($box);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    public function reset(Box $box)
    {
        //
        ResetBoxAction::execute($box);
        return response()->json(['O_Msg' => ''], 200);
    }

}
