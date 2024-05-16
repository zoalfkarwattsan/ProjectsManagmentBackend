<?php

namespace App\Modules\User\Controllers;

use App\Jobs\SyncCitizens;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use App\Modules\User\Actions\DeleteTempUserAction;
use App\Modules\User\Actions\ImmigrantTempUserAction;
use App\Modules\User\Actions\LocalizeTempUserAction;
use App\Modules\User\Actions\StoreUserAction;
use App\Modules\User\Actions\DeleteUserAction;
use App\Modules\User\Actions\UpdateUserAction;
use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Models\CitizensImport;
use App\Modules\User\Models\TempCitizen;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\StoreUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('municipality', function ($row) {
                return $row->municipality ? $row->municipality->name : '';
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mother_name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('gender', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('birth_date', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('record_religion', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('personal_religion', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['fname'])) {
                    $query->where('fname', 'like', "%" . request('filter')['fname'] . "%");
                }

                if (isset(request('filter')['mname'])) {
                    $query->where('mname', 'like', "%" . request('filter')['mname'] . "%");
                }

                if (isset(request('filter')['lname'])) {
                    $query->where('lname', 'like', "%" . request('filter')['lname'] . "%");
                }

                if (isset(request('filter')['mother_name'])) {
                    $query->where('mother_name', 'like', "%" . request('filter')['mother_name'] . "%");
                }

                if (isset(request('filter')['gender'])) {
                    $query->where('gender', 'like', "%" . request('filter')['gender'] . "%");
                }

                if (isset(request('filter')['civil_registration'])) {
                    $query->where('civil_registration', request('filter')['civil_registration']);
                }

                if (isset(request('filter')['record_religion'])) {
                    $query->where('record_religion', 'like', "%" . request('filter')['record_religion'] . "%");
                }

                if (isset(request('filter')['personal_religion'])) {
                    $query->where('personal_religion', 'like', "%" . request('filter')['personal_religion'] . "%");
                }

                if (isset(request('filter')['municipality'])) {
                    $query->whereIn('municipality_id', request('filter')['municipality']);
                }

                if (isset(request('filter')['birth_date']) && strlen(request('birth_date')) > 0) {
                    $query->where('birth_date', 'like', "%" . request('filter')['birth_date'] . "%");
                }
            })
            ->toJson();
        $data = Helper::createSuccessDTResponse($data, '');
        return response()->json($data, 200);
    }


    public function indexForElections(Request $request, Election $election)
    {
        $data = $election->users();
        $response = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('municipality', function ($row) {
                return $row->municipality_id ? Municipality::find($row->municipality_id) : '';
            })
            ->addColumn('responsible', function ($row) use ($election) {
                if ($row->responsible_id) {
                    $responsible = Responsible::find($row->responsible_id);
                    return $responsible;
                } else {
                    return [];
                }
            })
            ->editColumn('box', function ($row) use ($election) {
                return Box::find($row->box_id);
            })
            ->filter(function ($query) use ($election) {
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mother_name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('gender', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('birth_date', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('civil_registration', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('record_religion', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('personal_religion', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['fname'])) {
                    $query->where('fname', 'like', "%" . request('filter')['fname'] . "%");
                }

                if (isset(request('filter')['mname'])) {
                    $query->where('mname', 'like', "%" . request('filter')['mname'] . "%");
                }

                if (isset(request('filter')['lname'])) {
                    $query->where('lname', 'like', "%" . request('filter')['lname'] . "%");
                }

                if (isset(request('filter')['mother_name'])) {
                    $query->where('mother_name', 'like', "%" . request('filter')['mother_name'] . "%");
                }

                if (isset(request('filter')['gender'])) {
                    $query->where('gender', 'like', "%" . request('filter')['gender'] . "%");
                }

                if (isset(request('filter')['civil_registration'])) {
                    $query->where('civil_registration', request('filter')['civil_registration']);
                }

                if (isset(request('filter')['record_religion'])) {
                    $query->where('record_religion', 'like', "%" . request('filter')['record_religion'] . "%");
                }

                if (isset(request('filter')['personal_religion'])) {
                    $query->where('personal_religion', 'like', "%" . request('filter')['personal_religion'] . "%");
                }

                if (isset(request('filter')['municipality'])) {
                    $query->whereIn('municipality_id', request('filter')['municipality']);
                }

                if (isset(request('filter')['birth_date']) && strlen(request('filter')['birth_date']) > 0) {
                    $query->where('birth_date', 'like', "%" . request('filter')['birth_date'] . "%");
                }

                if (isset(request('filter')['responsibles'])) {
                    if (in_array(-1, request('filter')['responsibles'])) {
                        $query->whereNull('elections_vs_users.responsible_id');
                    } else {
                        $query->whereIn('responsible_id', request('filter')['responsibles']);
                    }
                }

                if (isset(request('filter')['immigrant'])) {
                    $query->where('outdoor', request('filter')['immigrant']);
                }

                if (isset(request('filter')['color'])) {
                    $query->where('elections_vs_users.color', request('filter')['color']);
                }

                if (isset(request('filter')['voted']) && request('filter')['voted'] > -1) {
                    $query->where('voted', request('filter')['voted']);
                }

                if (isset(request('filter')['arrived']) && request('filter')['arrived'] > -1) {
                    $query->where('arrived', request('filter')['arrived']);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($response, '');
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByBox(Request $request, Box $box)
    {
        $data = $box->users();
        $data = Datatables::of($data)
            ->editColumn('municipality', function ($row) {
                return $row->municipality_id ? Municipality::find($row->municipality_id) : '';
            })
            ->filter(function ($query) use ($box) {
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mother_name', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('gender', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('birth_date', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('record_religion', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('personal_religion', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['fname'])) {
                    $query->where('fname', 'like', "%" . request('filter')['fname'] . "%");
                }

                if (isset(request('filter')['mname'])) {
                    $query->where('mname', 'like', "%" . request('filter')['mname'] . "%");
                }

                if (isset(request('filter')['lname'])) {
                    $query->where('lname', 'like', "%" . request('filter')['lname'] . "%");
                }

                if (isset(request('filter')['mother_name'])) {
                    $query->where('mother_name', 'like', "%" . request('filter')['mother_name'] . "%");
                }

                if (isset(request('filter')['gender'])) {
                    $query->where('gender', 'like', "%" . request('filter')['gender'] . "%");
                }

                if (isset(request('filter')['record_religion'])) {
                    $query->where('record_religion', 'like', "%" . request('filter')['record_religion'] . "%");
                }

                if (isset(request('filter')['personal_religion'])) {
                    $query->where('personal_religion', 'like', "%" . request('filter')['personal_religion'] . "%");
                }

                if (isset(request('filter')['municipality'])) {
                    $query->where('municipality_id', 'like', "%" . request('filter')['municipality'] . "%");
                }

                if (isset(request('filter')['governate']) && request('filter')['governate'] > 0) {
                    $query->where('governate_id', 'like', "%" . request('filter')['governate'] . "%");
                }

                if (isset(request('filter')['province']) && request('filter')['province'] > 0) {
                    $query->where('province_id', 'like', "%" . request('filter')['province'] . "%");
                }

                if (isset(request('filter')['town']) && request('filter')['town'] > 0) {
                    $query->where('town_id', 'like', "%" . request('filter')['town'] . "%");
                }

                if (isset(request('filter')['constituency']) && request('filter')['constituency'] > 0) {
                    $query->where('constituency_id', 'like', "%" . request('filter')['constituency'] . "%");
                }

                if (isset(request('filter')['birth_date']) && strlen(request('filter')['birth_date']) > 0) {
                    $query->where('birth_date', 'like', "%" . request('filter')['birth_date'] . "%");
                }

                if (isset(request('filter')['responsibles'])) {
                    $query->whereIn('responsible_id', request('filter')['responsibles']);
                }

                if (isset(request('filter')['immigrant'])) {
                    $query->where('outdoor', request('filter')['immigrant']);
                }

                if (isset(request('filter')['color'])) {
                    $query->where('elections_vs_users.color', request('filter')['color']);
                }

                if (isset(request('filter')['voted']) && request('filter')['voted'] > -1) {
                    $query->where('voted', request('filter')['voted']);
                }

                if (isset(request('filter')['arrived']) && request('filter')['arrived'] > -1) {
                    $query->where('arrived', request('filter')['arrived']);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    public function getAllPersonalReligionsWithQ()
    {
        $response = Helper::createSuccessResponse(['personal_religions' => User::groupBy('personal_religion')->where('personal_religion', 'like', "%" . request('q') . "%")->limit(request('limit'))->pluck('personal_religion', 'personal_religion')], '');
        return response()->json($response, 200);
    }

    public function getAllRecordReligionsWithQ()
    {
        $response = Helper::createSuccessResponse(['record_religions' => User::groupBy('record_religion')->where('record_religion', 'like', "%" . request('q') . "%")->limit(request('limit'))->pluck('record_religion', 'record_religion')], '');
        return response()->json($response, 200);
    }

    public function getAllUsersMunicipalitiesWithQ()
    {
        // $response = Helper::createSuccessResponse(['municipalities' => Municipality::whereIn('id', User::all()->pluck('municipality_id'))->where('name', 'like', "%" . request('q') . "%")->limit(request('limit'))->get()], '');
        $response = Helper::createSuccessResponse(['municipalities' => Municipality::where('name', 'like', "%" . request('q') . "%")->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    public function getAllUsersMunicipalities()
    {
        // $response = Helper::createSuccessResponse(['municipalities' => Municipality::whereIn('id', User::all()->pluck('municipality_id'))->get()], '');
        $response = Helper::createSuccessResponse(['municipalities' => Municipality::all()], '');
        return response()->json($response, 200);
    }

    public function getAllNationalitiesWithQ()
    {
        $response = Helper::createSuccessResponse(['nationalities' => DB::table('nationalities')->where('name', 'like', "%" . request('q') . "%")->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    public function getAllUsersWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(['citizens' => User::where(function ($q) use ($request) {
            $q->where(DB::raw("CONCAT(`fname`, ' ', `mname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
            ->orWhere(DB::raw("CONCAT(`fname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%");
        })->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    public function storeImportedCitizens(Request $request, Election $election)
    {
        set_time_limit(0);
        $file = request()->file('file');
        Excel::import(new CitizensImport($election), $file);
        $response = Helper::createSuccessResponse(null, 'Imported Successfully!');
        return response()->json($response, 200);
    }

    public function syncImportedCitizens(Election $election)
    {
        SyncCitizens::dispatch($election);
        return response()->json(['message' => 'Syncronizing'], 200);
    }

    public function assignToResponsible(Request $request, Election $election)
    {
        $responsible_ids = DB::table('elections_vs_users')
            ->where('election_id', $election->id)
            ->whereIn('user_id', $request->user_ids)->pluck('responsible_id');
        DB::table('elections_vs_users')
            ->where('election_id', $election->id)
            ->whereIn('user_id', $request->user_ids)
            ->update(['responsible_id' => $request->responsible_id, 'outdoor' => 0]);
        if ($request->responsible_id) {
            $responsible = Responsible::find($request->responsible_id);
            $responsible->update(['last_sync_at' => Carbon::now()]);
        }
        if (count($responsible_ids) > 0) {
            Responsible::whereIn('id', $responsible_ids)->update(['last_sync_at' => Carbon::now()]);
        }
        return response()->json(['message' => 'success'], 200);
    }

    public function changeColor(Request $request, Election $election)
    {
        DB::table('elections_vs_users')
            ->where('election_id', $election->id)
            ->whereIn('user_id', $request->user_ids)
            ->update(['color' => $request->color]);
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $storeUserRequest)
    {
        $userDTO = UserDTO::fromRequest($storeUserRequest);
        Helper::createSuccessResponse(StoreUserAction::execute($userDTO));
        return response()->json(['message' => 'New User Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $updateUserRequest, User $user)
    {
        $userDTO = UserDTO::fromRequestForUpdate($updateUserRequest, $user);
        Helper::createSuccessResponse(UpdateUserAction::execute($user, $userDTO));
        return response()->json(['message' => 'User Edited Successfully!'], 200);
    }

    public function show(User $user)
    {
        return response()->json(Helper::createSuccessResponse($user), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        //
        DeleteUserAction::execute($user);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TempCitizen $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTempUser(TempCitizen $user)
    {
        //
        DeleteTempUserAction::execute($user);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $User
     * @return \Illuminate\Http\JsonResponse
     */
    public function immigrantTempUser(User $user, Election $election)
    {
        //
        ImmigrantTempUserAction::execute($user, $election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    public function localizeTempUser(User $user, Election $election)
    {
        //
        LocalizeTempUserAction::execute($user, $election);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

}
