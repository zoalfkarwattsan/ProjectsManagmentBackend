<?php

namespace App\Modules\Status\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Status\Actions\StoreStatusAction;
use App\Modules\Status\Actions\DeleteStatusAction;
use App\Modules\Status\Actions\UpdateStatusAction;
use App\Modules\Status\DTO\StatusDTO;
use App\Modules\Status\Models\Status;
use App\Modules\Status\Requests\StoreStatusRequest;
use App\Modules\Status\Requests\UpdateStatusRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatusDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Status::select('*');
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

                if (isset(request('filter')['icon_color'])) {
                    $query->where('icon_color', 'like', "%" . request('filter')['icon_color'] . "%");
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
    public function store(StoreStatusRequest $storeStatusRequest)
    {
        $statusDTO = StatusDTO::fromRequest($storeStatusRequest);
        $status = Status::where('name', $storeStatusRequest->name)->first();
        if (!$status) {
            $status = StoreStatusAction::execute($statusDTO);
        }
        if ($storeStatusRequest->election) {
            $election = Election::find($storeStatusRequest->election);
            $election->statuses()->attach($status->id);
        }
        Helper::createSuccessResponse($status);
        return response()->json(['message' => 'New TransactionStatus Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $updateStatusRequest, Status $status)
    {
        $statusDTO = StatusDTO::fromRequestForUpdate($updateStatusRequest, $status);
        $response = Helper::createSuccessResponse(UpdateStatusAction::execute($status, $statusDTO), '');
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
