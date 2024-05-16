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
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use function request;
use function response;

class PermissionDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Permission::select('*');
        $data = Datatables::of($data)
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%");
                }

                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
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
    public function store(StorePermissionRequest $storePermissionRequest)
    {
        $permissionDTO = PermissionDTO::fromRequest($storePermissionRequest);
        $response = Helper::createSuccessResponse(StorePermissionAction::execute($permissionDTO));
        return response()->json(['message' => 'New Permission Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $updatePermissionRequest, Permission $permission)
    {

        $permissionDTO = PermissionDTO::fromRequestForUpdate($updatePermissionRequest, $permission);
        $response = Helper::createSuccessResponse(UpdatePermissionAction::execute($permission, $permissionDTO));
        return response()->json(['message' => 'Permission Edited Successfully!'], 200);
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
