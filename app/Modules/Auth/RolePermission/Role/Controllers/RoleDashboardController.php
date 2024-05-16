<?php

namespace App\Modules\Auth\RolePermission\Role\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\Auth\RolePermission\Role\Actions\DeleteRoleAction;
use App\Modules\Auth\RolePermission\Role\Actions\StoreRoleAction;
use App\Modules\Auth\RolePermission\Role\Actions\UpdateRoleAction;
use App\Modules\Auth\RolePermission\Role\DTO\RoleDTO;
use App\Modules\Auth\RolePermission\Role\Models\Role;
use App\Modules\Auth\RolePermission\Role\Requests\StoreRoleRequest;
use App\Modules\Auth\RolePermission\Role\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use function request;
use function response;

class RoleDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Role::select('*');
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
    public function store(StoreRoleRequest $storeRoleRequest)
    {
        $roleDTO = RoleDTO::fromRequest($storeRoleRequest);
        $response = Helper::createSuccessResponse(StoreRoleAction::execute($roleDTO));
        return response()->json(['message' => 'New Role Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $updateRoleRequest, Role $role)
    {

        $roleDTO = RoleDTO::fromRequestForUpdate($updateRoleRequest, $role);
        $response = Helper::createSuccessResponse(UpdateRoleAction::execute($role, $roleDTO));
        return response()->json(['message' => 'Role Edited Successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        //
        DeleteRoleAction::execute($role);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
