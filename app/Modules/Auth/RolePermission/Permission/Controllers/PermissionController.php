<?php

namespace App\Modules\Auth\RolePermission\Permission\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\Auth\RolePermission\Permission\Actions\DeletePermissionAction;
use App\Modules\Auth\RolePermission\Permission\Actions\StorePermissionAction;
use App\Modules\Auth\RolePermission\Permission\Actions\UpdatePermissionAction;
use App\Modules\Auth\RolePermission\Permission\DTO\PermissionDTO;
use App\Modules\Auth\RolePermission\Permission\Models\Permission;
use App\Modules\Auth\RolePermission\Permission\Requests\StorePermissionRequest;
use App\Modules\Auth\RolePermission\Permission\Requests\UpdatePermissionRequest;
use App\Modules\Auth\RolePermission\Permission\ViewModels\PermissionIndexVM;
use App\Modules\Auth\RolePermission\Permission\ViewModels\PermissionShowVM;
use function response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(PermissionIndexVM::toArray());
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StorePermissionRequest $createPermissionRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePermissionRequest $createPermissionRequest)
    {
        //
        $permissionDTO = PermissionDTO::fromRequest($createPermissionRequest);
        $response = Helper::createSuccessResponse(StorePermissionAction::execute($permissionDTO));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Permission $permission)
    {
        //
        $response = Helper::createSuccessResponse(PermissionShowVM::toArray($permission));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePermissionRequest $updatePermissionRequest
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePermissionRequest $updatePermissionRequest, Permission $permission)
    {
        //
        $permissionDTO = PermissionDTO::fromRequestForUpdate($updatePermissionRequest, $permission);
        $response = Helper::createSuccessResponse(PermissionShowVM::toArray(UpdatePermissionAction::execute($permission, $permissionDTO)));
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        //
        DeletePermissionAction::execute($permission);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }
}
