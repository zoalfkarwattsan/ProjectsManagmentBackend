<?php

namespace App\Modules\Announcement\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Announcement\Actions\StoreAnnouncementAction;
use App\Modules\Announcement\Actions\DeleteAnnouncementAction;
use App\Modules\Announcement\Actions\UpdateAnnouncementAction;
use App\Modules\Announcement\DTO\AnnouncementDTO;
use App\Modules\Announcement\Models\Announcement;
use App\Modules\Announcement\Requests\StoreAnnouncementRequest;
use App\Modules\Announcement\Requests\UpdateAnnouncementRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Announcement::select('*');
        $data = Datatables::of($data)
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('text', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['text'])) {
                    $query->where('text', 'like', "%" . request('filter')['text'] . "%");
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
    public function store(StoreAnnouncementRequest $storeAnnouncementRequest)
    {
        $announcementDTO = AnnouncementDTO::fromRequest($storeAnnouncementRequest);
        $announcement = StoreAnnouncementAction::execute($announcementDTO);
        Helper::createSuccessResponse($announcement);
        return response()->json(['message' => 'New Announcement Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnnouncementRequest $updateAnnouncementRequest, Announcement $announcement)
    {
        $announcementDTO = AnnouncementDTO::fromRequestForUpdate($updateAnnouncementRequest, $announcement);
        Helper::createSuccessResponse(UpdateAnnouncementAction::execute($announcement, $announcementDTO));
        return response()->json(['message' => 'Announcement Edited Successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Announcement $Announcement
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Announcement $announcement)
    {
        //
        DeleteAnnouncementAction::execute($announcement);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
