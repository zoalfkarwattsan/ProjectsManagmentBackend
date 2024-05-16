<?php

namespace App\Modules\Auth\Admin\Controllers;

use App\Modules\Auth\Admin\Actions\StoreAdminAction;
use App\Modules\Auth\Admin\Actions\DeleteAdminAction;
use App\Modules\Auth\Admin\Actions\UpdateAdminAction;
use App\Modules\Auth\Admin\DTO\AdminDTO;
use App\Modules\Auth\Admin\Models\Admin;
use App\Modules\Auth\Admin\Requests\StoreAdminRequest;
use App\Modules\Auth\Admin\Requests\UpdateAdminRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Admin::select('*');
        $data = Datatables::of($data)
            ->addColumn('role_name', function ($row) {
                return $row->role->name;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('email', 'like', "%" . request('search')['value'] . "%");
                }

                if (isset(request('filter')['name'])) {
                    $query->where('name', 'like', "%" . request('filter')['name'] . "%");
                }

                if (isset(request('filter')['email'])) {
                    $query->where('email', 'like', "%" . request('filter')['email'] . "%");
                }

            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }


    public function getAllAdminsWithQ()
    {
        $response = Helper::createSuccessResponse(['municipalities' => Admin::where('name', 'like', "%" . request('q') . "%")->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }


    public function getAllAdminsWithoutCenterWithQ()
    {
        $response = Helper::createSuccessResponse(['admins' => Admin::where('name', 'like', "%" . request('q') . "%")->whereNull('center_id')->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $storeAdminRequest)
    {
        $adminDTO = AdminDTO::fromRequest($storeAdminRequest);
        $response = Helper::createSuccessResponse(StoreAdminAction::execute($adminDTO));
        return response()->json(['message' => 'New Admin Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $updateAdminRequest, Admin $admin)
    {

        $adminDTO = AdminDTO::fromRequestForUpdate($updateAdminRequest, $admin);
        $response = Helper::createSuccessResponse(UpdateAdminAction::execute($admin, $adminDTO));
        return response()->json(['message' => 'Admin Edited Successfully!'], 200);
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
    public function show( Admin $admin)
    {

       return $admin;
        return response()->json(['message' => 'Admin Edited Successfully!'], 200);
    }

}
