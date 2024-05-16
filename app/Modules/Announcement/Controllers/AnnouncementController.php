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
use App\Modules\Announcement\ViewModels\AnnouncementIndexByActiveElectionVM;
use App\Modules\Announcement\ViewModels\AnnouncementIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Announcement\ViewModels\AnnouncementShowVM;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(AnnouncementIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Display a listing of the resource by Active Election
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function activeAnnouncements()
  {
    $response = Helper::createSuccessResponse(AnnouncementIndexByActiveElectionVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreAnnouncementRequest $createAnnouncementRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreAnnouncementRequest $createAnnouncementRequest)
  {
    //
    $AnnouncementDTO = AnnouncementDTO::fromRequest($createAnnouncementRequest);
    $response = Helper::createSuccessResponse(StoreAnnouncementAction::execute($AnnouncementDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Announcement $Announcement
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Announcement $announcement)
  {
    //
    $response = Helper::createSuccessResponse(AnnouncementShowVM::toArray($announcement));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateAnnouncementRequest $updateAnnouncementRequest
   * @param Announcement $Announcement
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateAnnouncementRequest $updateAnnouncementRequest, Announcement $announcement)
  {
    //
    $announcementDTO = AnnouncementDTO::fromRequestForUpdate($updateAnnouncementRequest, $announcement);
    $response = Helper::createSuccessResponse(AnnouncementShowVM::toArray(UpdateAnnouncementAction::execute($announcement, $announcementDTO)));
    return response()->json($response, 200);
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
