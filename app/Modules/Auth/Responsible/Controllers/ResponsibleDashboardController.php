<?php

namespace App\Modules\Auth\Responsible\Controllers;

use App\Modules\Auth\Responsible\Actions\ActivateTeamMemberAction;
use App\Modules\Auth\Responsible\Actions\DeactivateTeamMemberAction;
use App\Modules\Auth\Responsible\Actions\DeleteResponsibleAction;
use App\Modules\Auth\Responsible\Actions\StoreResponsibleAction;
use App\Modules\Auth\Responsible\Actions\UpdateResponsibleAction;
use App\Modules\Auth\Responsible\DTO\ResponsibleDTO;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Auth\Responsible\Requests\StoreResponsibleRequest;
use App\Modules\Auth\Responsible\Requests\UpdateResponsibleRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Election\Models\Election;
use App\Modules\Project\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ResponsibleDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Responsible::select('*');
        $response = Datatables::of($data)
            ->editColumn('created_by', function ($row) {
                return $row->created_by ? $row->created_by->name : null;
            })
            ->editColumn('name', function ($row) {
                return $row->fname . ' ' . $row->lname;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('email', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('phone', 'like', "%" . request('search')['value'] . "%");
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

                if (isset(request('filter')['type'])) {
                    // $query->join('responsibles_vs_responsible_types', function ($join) {
                    //     $join->on('responsibles.id', '=', 'responsibles_vs_responsible_types.responsible_id')
                    //          ->where('responsibles_vs_responsible_types.responsible_type_id', '=', request('filter')['type']);
                    // });
                    $query->whereIn('id', DB::table('responsibles_vs_responsible_types')->where('responsible_type_id', request('filter')['type'])->get()->pluck('responsible_id'));
                }

                if (isset(request('filter')['phone'])) {
                    $query->where('phone', 'like', "%" . request('filter')['phone'] . "%");
                }

                if (isset(request('filter')['has_fcm'])) {
                    $query->whereNotNull('fcm_token');
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($response, '');
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResponsibleRequest $storeResponsibleRequest)
    {
        $responsibleDTO = ResponsibleDTO::fromRequest($storeResponsibleRequest);
        Helper::createSuccessResponse(StoreResponsibleAction::execute($responsibleDTO, $storeResponsibleRequest->responsible_types));
        return response()->json(['message' => 'New Responsible Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponsibleRequest $updateResponsibleRequest, Responsible $responsible)
    {
        $responsibleDTO = ResponsibleDTO::fromRequestForUpdate($updateResponsibleRequest, $responsible);
        return UpdateResponsibleAction::execute($responsible, $responsibleDTO, $updateResponsibleRequest->responsible_types);
        Helper::createSuccessResponse(UpdateResponsibleAction::execute($responsible, $responsibleDTO, $updateResponsibleRequest->responsible_types));
        return response()->json(['message' => 'Responsible Edited Successfully!'], 200);
    }

    public function show(Responsible $responsible)
    {
        $responsible->projects;
        $responsible->tasks;
        $responsible->responsible_types;
        $response = Helper::createSuccessResponse($responsible);
        return response()->json($response, 200);
    }

    public function getAllProjectManagersWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(['projectmanagers' => DB::table('responsibles')
            ->where(DB::raw("CONCAT(`fname`, ' ', `mname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
            ->orWhere(DB::raw("CONCAT(`fname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
            ->orWhere('email', 'like', '%' . $request->q . '%')
            ->join('responsibles_vs_responsible_types', function ($join) {
                $join->on('responsibles.id', '=', 'responsibles_vs_responsible_types.responsible_id')
                    ->where('responsibles_vs_responsible_types.responsible_type_id', '=', 1);
            })
            ->select('responsibles.id', 'responsibles.fname', 'responsibles.mname', 'responsibles.lname')
            ->limit(request('limit'))
            ->get()], '');
        return response()->json($response, 200);
    }

    public function getAllProjectManagersForProjectWithQ(Request $request, Project $project)
    {
        $response = Helper::createSuccessResponse(['projectmanagers' => DB::table('responsibles')
            ->where(DB::raw("CONCAT(`fname`, ' ', `mname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
            ->orWhere(DB::raw("CONCAT(`fname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
            ->orWhere('email', 'like', '%' . $request->q . '%')
            ->join('responsibles_vs_responsible_types', function ($join) {
                $join->on('responsibles.id', '=', 'responsibles_vs_responsible_types.responsible_id')
                    ->where('responsibles_vs_responsible_types.responsible_type_id', '=', 1);
            })
            ->join('projects_vs_responsibles', function ($join) use ($project) {
                $join->on('responsibles.id', '=', 'projects_vs_responsibles.responsible_id')
                    ->where('projects_vs_responsibles.project_id', '=', $project->id);
            })
            ->select('responsibles.id', 'responsibles.fname', 'responsibles.mname', 'responsibles.lname')
            ->limit(request('limit'))->get()], '');
        return response()->json($response, 200);
    }

    public function getAllDelegatesWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(['delegates' => [

            [
                "id" => -1,
                "fname" => "No Delegate",
                "mname" => "",
                "lname" => ""
            ],
            ...DB::table('responsibles')
                ->where(DB::raw("CONCAT(`fname`, ' ', `mname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
                ->orWhere(DB::raw("CONCAT(`fname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
                ->orWhere('email', 'like', '%' . $request->q . '%')
                ->join('responsibles_vs_responsible_types', function ($join) {
                    $join->on('responsibles.id', '=', 'responsibles_vs_responsible_types.responsible_id')
                        ->where('responsibles_vs_responsible_types.responsible_type_id', '=', 2);
                })
                ->select('responsibles.id', 'responsibles.fname', 'responsibles.mname', 'responsibles.lname')
                ->limit(request('limit'))
                ->get()
        ]], '');
        return response()->json($response, 200);
    }

    public function getAllResponsiblesWithQ(Request $request)
    {
        $response = Helper::createSuccessResponse(['responsibles' => [
            [
                "id" => -1,
                "fname" => "No Responsible",
                "mname" => "",
                "lname" => ""
            ],
            ...DB::table('responsibles')
                ->where(DB::raw("CONCAT(`fname`, ' ', `mname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
                ->orWhere(DB::raw("CONCAT(`fname`, ' ', `lname`)"), 'LIKE', "%" . $request->q . "%")
                ->orWhere('email', 'like', '%' . $request->q . '%')
                ->join('responsibles_vs_responsible_types', function ($join) {
                    $join->on('responsibles.id', '=', 'responsibles_vs_responsible_types.responsible_id')
                        ->where('responsibles_vs_responsible_types.responsible_type_id', '=', 3);
                })
                ->select('responsibles.id', 'responsibles.fname', 'responsibles.mname', 'responsibles.lname')
                ->limit(request('limit'))
                ->get()
        ]], '');
        return response()->json($response, 200);
    }

    public function indexQResponsiblesList(Request $request)
    {
        $responsibles = Responsible::where(function ($q) use ($request) {
            $q->where('fname', 'like', '%' . $request->q . '%')
                ->orWhere('lname', 'like', '%' . $request->q . '%')
                ->orWhere('mname', 'like', '%' . $request->q . '%')
                ->orWhere('email', 'like', '%' . $request->q . '%');
        })->whereNotIn('id', $request->ids ?? [])
            ->paginate(10);
        return response()->json($responsibles);
    }

    public function getAssignedUserByActiveElection()
    {
        $election = Election::where('active', 1)->first();
        if (!$election) return null;
        $responsible = Responsible::find(Auth::id());
        $citizens = $election->users()->wherePivot('responsible_id', $responsible->id)->get();
        $data = Helper::createSuccessResponse(['citizens' => $citizens, 'last_sync_at' => $responsible->last_sync_at], '');
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Responsible $Responsible
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Responsible $responsible)
    {
        //
        DeleteResponsibleAction::execute($responsible);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

    public function activateTeamMember(Responsible $responsible)
    {
        //
        ActivateTeamMemberAction::execute($responsible);
        return response()->json(['O_Msg' => ''], 200);
    }

    public function deActivateTeamMember(Responsible $responsible)
    {
        //
        DeactivateTeamMemberAction::execute($responsible);
        return response()->json(['O_Msg' => ''], 200);
    }

}
