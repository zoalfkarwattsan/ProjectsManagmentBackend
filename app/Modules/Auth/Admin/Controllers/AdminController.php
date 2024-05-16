<?php

namespace App\Modules\Auth\Admin\Controllers;

use App\Modules\Auth\Admin\Actions\StoreAdminAction;
use App\Modules\Auth\Admin\Actions\DeleteAdminAction;
use App\Modules\Auth\Admin\Actions\UpdateAdminAction;
use App\Modules\Auth\Admin\DTO\AdminDTO;
use App\Modules\Auth\Admin\Models\Admin;
use App\Modules\Auth\Admin\Requests\StoreAdminRequest;
use App\Modules\Auth\Admin\Requests\UpdateAdminRequest;
use App\Modules\Auth\Admin\ViewModels\AdminIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Auth\Admin\ViewModels\AdminShowVM;

class AdminController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(AdminIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreAdminRequest $createAdminRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreAdminRequest $createAdminRequest)
  {
    //
    $AdminDTO = AdminDTO::fromRequest($createAdminRequest);
    $response = Helper::createSuccessResponse(StoreAdminAction::execute($AdminDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param Admin $Admin
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(Admin $admin)
  {
    //
    $response = Helper::createSuccessResponse(AdminShowVM::toArray($admin));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateAdminRequest $updateAdminRequest
   * @param Admin $Admin
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateAdminRequest $updateAdminRequest, Admin $admin)
  {
    //
    $adminDTO = AdminDTO::fromRequestForUpdate($updateAdminRequest, $admin);
    $response = Helper::createSuccessResponse(AdminShowVM::toArray(UpdateAdminAction::execute($admin, $adminDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Admin $Admin
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(Admin $admin)
  {
    //
    DeleteAdminAction::execute($admin);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
