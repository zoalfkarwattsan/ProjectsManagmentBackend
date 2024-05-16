<?php

namespace App\Modules\Auth\Notification\Controllers;

use App\Modules\Auth\Notification\Actions\StoreNotificationAction;
use App\Modules\Auth\Notification\Actions\DeleteNotificationAction;
use App\Modules\Auth\Notification\Actions\UpdateNotificationAction;
use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Notification\Models\Notification;
use App\Modules\Auth\Notification\Requests\StoreNotificationRequest;
use App\Modules\Auth\Notification\Requests\UpdateNotificationRequest;
use App\Modules\Auth\Notification\ViewModels\NotificationIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Auth\Notification\ViewModels\NotificationShowVM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Helper::createSuccessResponse(NotificationIndexVM::toArray());
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllNotificationByAuth()
    {
        $user = Auth::guard('api')->user();
        $response = Helper::createSuccessResponse($user->notifications);
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * //     * @param StoreNotificationRequest $createNotificationRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNotificationRequest $createNotificationRequest)
    {
        //
        $NotificationDTO = NotificationDTO::fromRequest($createNotificationRequest);
        $response = Helper::createSuccessResponse(StoreNotificationAction::execute($NotificationDTO));
        return response()->json($response, 200);
    }

    public function storeToken(Request $request)
    {
        Auth::guard('api')->user()->update(['fcm_token' => $request->token]);
        return response()->json(['Token successfully stored.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $Notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Notification $user)
    {
        //
        $response = Helper::createSuccessResponse(NotificationShowVM::toArray($user));
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNotificationRequest $updateNotificationRequest
     * @param Notification $Notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateNotificationRequest $updateNotificationRequest, Notification $user)
    {
        //
        $userDTO = NotificationDTO::fromRequestForUpdate($updateNotificationRequest, $user);
        $response = Helper::createSuccessResponse(NotificationShowVM::toArray(UpdateNotificationAction::execute($user, $userDTO)));
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $Notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $user)
    {
        //
        DeleteNotificationAction::execute($user);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }
}
