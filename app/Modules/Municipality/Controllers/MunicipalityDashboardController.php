<?php

namespace App\Modules\Municipality\Controllers;

use App\Modules\Election\Models\Election;
use App\Modules\Municipality\Actions\StoreMunicipalityAction;
use App\Modules\Municipality\Actions\DeleteMunicipalityAction;
use App\Modules\Municipality\Actions\UpdateMunicipalityAction;
use App\Modules\Municipality\DTO\MunicipalityDTO;
use App\Modules\Municipality\Models\Municipality;
use App\Modules\Municipality\Requests\StoreMunicipalityRequest;
use App\Modules\Municipality\Requests\UpdateMunicipalityRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MunicipalityDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Municipality::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
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

    public function indexQMunicipalities(Request $request)
    {
        $municipalities = Municipality::where('name', 'like', '%' . $request->q . '%')->paginate(10);
        return response()->json($municipalities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMunicipalityRequest $storeMunicipalityRequest)
    {
        $municipalityDTO = MunicipalityDTO::fromRequest($storeMunicipalityRequest);
        $municipality = StoreMunicipalityAction::execute($municipalityDTO);
        Helper::createSuccessResponse($municipality);
        return response()->json(['message' => 'New Municipality Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMunicipalityRequest $updateMunicipalityRequest, Municipality $municipality)
    {
        $municipalityDTO = MunicipalityDTO::fromRequestForUpdate($updateMunicipalityRequest, $municipality);
        Helper::createSuccessResponse(UpdateMunicipalityAction::execute($municipality, $municipalityDTO));
        return response()->json(['message' => 'Municipality Edited Successfully!'], 200);
    }

    public function getReligions(Municipality $municipality)
    {
        $religions = User::where('municipality_id', $municipality->id)->groupBy('record_religion')->pluck('record_religion', 'record_religion');
        $select = view('project-pages.boxes.municipality-religion', ['religions' => $religions])->render();
        return response()->json(['select' => $select], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Municipality $Municipality
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Municipality $municipality)
    {
        //
        DeleteMunicipalityAction::execute($municipality);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
