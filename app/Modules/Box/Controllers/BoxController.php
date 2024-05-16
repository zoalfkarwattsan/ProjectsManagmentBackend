<?php

namespace App\Modules\Box\Controllers;

use App\Modules\Box\Actions\ArrivedCitizenAction;
use App\Modules\Box\Actions\CloseRequestBoxAction;
use App\Modules\Box\Actions\StoreBoxAction;
use App\Modules\Box\Actions\DeleteBoxAction;
use App\Modules\Box\Actions\UpdateBoxAction;
use App\Modules\Box\Actions\VoteCitizenAction;
use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\DTO\RealVoteDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Box\Requests\StoreBoxRequest;
use App\Modules\Box\Requests\UpdateBoxRequest;
use App\Modules\Box\ViewModels\ActiveBoxShowVM;
use App\Modules\Box\ViewModels\BoxIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Box\ViewModels\BoxShowVM;
use App\Modules\Election\Actions\StoreRealVoteAction;
use App\Modules\User\Models\User;

//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(BoxIndexVM::toArray());
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StoreBoxRequest $createBoxRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBoxRequest $createBoxRequest)
    {
        //
        $BoxDTO = BoxDTO::fromRequest($createBoxRequest);
        $response = Helper::createSuccessResponse(StoreBoxAction::execute($BoxDTO));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Box $box)
    {
        //
        $response = Helper::createSuccessResponse(BoxShowVM::toArray($box));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function showActiveByAuth(Box $box)
    {
        //
        $response = Helper::createSuccessResponse(ActiveBoxShowVM::toArray($box));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function closeBoxByAuth()
    {
        //
        $response = Helper::createSuccessResponse(CloseRequestBoxAction::execute());
        return response()->json($response, 200);
    }

    public function realVote(Request $request)
    {
        //
        $response = Helper::createSuccessResponse(StoreRealVoteAction::execute($request));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function citizenVote(User $user)
    {
        //
        $response = Helper::createSuccessResponse(VoteCitizenAction::execute($user));
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function citizenArrived(User $user)
    {
        //
        $response = Helper::createSuccessResponse(ArrivedCitizenAction::execute($user));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBoxRequest $updateBoxRequest
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateBoxRequest $updateBoxRequest, Box $box)
    {
        //
        $boxDTO = BoxDTO::fromRequestForUpdate($updateBoxRequest, $box);
        $response = Helper::createSuccessResponse(BoxShowVM::toArray(UpdateBoxAction::execute($box, $boxDTO)));
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Box $Box
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Box $box)
    {
        //
        DeleteBoxAction::execute($box);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }
}
