<?php

namespace App\Modules\Auth\RolePermission\Role\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Modules\Auth\RolePermission\Role\Actions\AssignPermissionToRole;
use App\Modules\Auth\RolePermission\Role\Actions\DeleteRoleAction;
use App\Modules\Auth\RolePermission\Role\Actions\StoreRoleAction;
use App\Modules\Auth\RolePermission\Role\Actions\UpdateRoleAction;
use App\Modules\Auth\RolePermission\Role\DTO\RoleDTO;
use App\Modules\Auth\RolePermission\Role\Models\Role;
use App\Modules\Auth\RolePermission\Role\Requests\StoreRoleRequest;
use App\Modules\Auth\RolePermission\Role\Requests\UpdateRoleRequest;
use App\Modules\Auth\RolePermission\Role\ViewModels\RoleIndexVM;
use App\Modules\Auth\RolePermission\Role\ViewModels\RoleShowVM;
use function response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(RoleIndexVM::toArray());
        return response()->json($response, 200);
    }

    public function getAllRolesWithQ()
    {
        $response = Helper::createSuccessResponse(['roles' => Role::where('name', 'like', "%" . request('q') . "%")->where('locked', 0)->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StoreRoleRequest $createRoleRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $createRoleRequest)
    {
        //
        $roleDTO = RoleDTO::fromRequest($createRoleRequest);
        $role = StoreRoleAction::execute($roleDTO);
        $response = Helper::createSuccessResponse(AssignPermissionToRole::execute($role->id, $createRoleRequest->permissions));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        //
        $response = Helper::createSuccessResponse(RoleShowVM::toArray($role));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $updateRoleRequest
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $updateRoleRequest, Role $role)
    {
        //
        $roleDTO = RoleDTO::fromRequestForUpdate($updateRoleRequest, $role);
        $role = UpdateRoleAction::execute($role, $roleDTO);
        $response = Helper::createSuccessResponse(AssignPermissionToRole::execute($role->id, $updateRoleRequest->permissions));
        return response()->json($response, 200);
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
