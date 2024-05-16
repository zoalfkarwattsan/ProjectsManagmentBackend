<?php

namespace App\Modules\Auth\Notification\Controllers;

use App\Modules\Auth\Notification\Actions\StoreNotificationAction;
use App\Modules\Auth\Notification\Actions\DeleteNotificationAction;
use App\Modules\Auth\Notification\Actions\UpdateNotificationAction;
use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Notification\Models\Notification;
use App\Modules\Auth\Notification\Requests\StoreNotificationRequest;
use App\Modules\Auth\Notification\Requests\UpdateNotificationRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\Auth\Responsible\Models\Responsible;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Notification::select('*');
        $data = Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row['created_at'])->format('d/m/Y - H:i');
            })
            ->editColumn('created_by', function ($row) {
                return $row->created_by->name;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('title', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('body', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['title'])) {
                    $query->where('title', 'like', "%" . request('filter')['title'] . "%");
                }

                if (isset(request('filter')['body'])) {
                    $query->where('body', 'like', "%" . request('filter')['body'] . "%");
                }

                if (isset(request('filter')['created_by'])) {
                    $query->whereIn('created_by_id', request('filter')['created_by']);
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifiedIndex(Request $request)
    {
        $data = Responsible::select('*')->whereNotNull('fcm_token');
        $data = Datatables::of($data)
            ->editColumn('action', function ($row) {
                $html = '<fieldset>
                    <div class="checkbox">
                      <input type="checkbox" class="checkbox-input" id="checkbox' . $row->id . '"  value="' . $row->fcm_token . '" name="responsibles[]">
                      <label for="checkbox' . $row->id . '"></label>
                    </div>
                  </fieldset>';
                return $html;
            })
            ->editColumn('type', function ($row) {
                return $row->responsible_type->name;
            })
            ->editColumn('created_by', function ($row) {
                return $row->created_by->name;
            })
            ->filter(function ($query) {
                if (isset(request('search')['value'])) {
                    $query->where('fname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('mname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('lname', 'like', "%" . request('search')['value'] . "%")
                        ->orWhere('email', 'like', "%" . request('search')['value'] . "%");
                }
                if (isset(request('filter')['fname'])) {
                    $query->where('fname', 'like', "%" . request('fname') . "%");
                }

                if (isset(request('filter')['mname'])) {
                    $query->where('mname', 'like', "%" . request('mname') . "%");
                }

                if (isset(request('filter')['lname'])) {
                    $query->where('lname', 'like', "%" . request('lname') . "%");
                }

                if (isset(request('filter')['email'])) {
                    $query->where('email', 'like', "%" . request('email') . "%");
                }
            })
            ->toJson();
        $response = Helper::createSuccessDTResponse($data, '');
        return response()->json($response, 200);
        $data = [
            'columns' => [
                ['data' => 'action', 'orderable' => false, 'searchable' => false, 'class' => 'checkbox-nonsort',
                    'div' => '<fieldset>
                    <div class="checkbox">
                      <input type="checkbox" class="checkbox-input" id="clickAll">
                      <label for="clickAll"></label>
                    </div>
                  </fieldset>'
                ],
                //['data' => 'id', 'name' => 'ID'],
                ['data' => 'fname', 'name' => 'fname'],
                ['data' => 'mname', 'name' => 'mname'],
                ['data' => 'lname', 'name' => 'lname'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'phone', 'name' => 'phone'],
                ['data' => 'type', 'name' => 'type', 'searchable' => false],
            ],
            'title' => 'Responsibles List',
            'subtitle' => 'This is the list of our responsibles',
            'url' => route('notify.responsibles')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $storeNotificationRequest)
    {
        $notificationDTO = NotificationDTO::fromRequest($storeNotificationRequest);
        Helper::createSuccessResponse(StoreNotificationAction::execute($notificationDTO));
        return response()->json(['message' => 'New Notification Added Successfully!'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $updateNotificationRequest, Notification $notification)
    {
        $notificationDTO = NotificationDTO::fromRequestForUpdate($updateNotificationRequest, $notification);
        Helper::createSuccessResponse(UpdateNotificationAction::execute($notification, $notificationDTO));
        return response()->json(['message' => 'Notification Edited Successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $Notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $notification)
    {
        //
        DeleteNotificationAction::execute($notification);
        return response()->json(['O_Msg' => 'Item Deleted'], 200);
    }

//  public function sendWebNotification(Request $request)
//  {
//    $url = 'https://fcm.googleapis.com/fcm/send';
//    $FcmToken = Responsible::whereNotNull('fcm_token')->pluck('fcm_token')->all();
//
//    $serverKey = 'AAAA-XgexyE:APA91bHHKcOYqV2AXQyPSZ1y8K1aXPY1jOaN_LoYIzdLotBd0WTJLZnoOLP1U6RfOD-hYWp0JgRSroICnjhi-QiW2vhr7NEpGm-Dh0anggVlg2gfWPFfylXkTbQzWN2lvQ-S7htxp9r5';
//
//    $data = [
//      "registration_ids" => ['cZjIAJzkQUadAM_8Drl_pi:APA91bHXoYJaFeVJV8ossnfZXlxVOkFJcQQI1NZPvwswJj4_QKNv_x6gaGbYh7x2_E2EJnjAiWq9S_vKSRNW2XZdCZbCoFt3fB-tTGRe77H4wcHyi4o4iFG2qhWHTTAUBk07pSry1R1-'],
//      "notification" => [
//        "title" => $request->title,
//        "body" => $request->body,
//      ]
//    ];
//    $encodedData = json_encode($data);
//
//    $headers = [
//      'Authorization:key=' . $serverKey,
//      'Content-Type: application/json',
//    ];
//
//    $ch = curl_init();
//
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
//    // Disabling SSL Certificate support temporarly
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
//
//    // Execute post
//    $result = curl_exec($ch);
//
//    if ($result === FALSE) {
//      die('Curl failed: ' . curl_error($ch));
//    }
//
//    // Close connection
//    curl_close($ch);
//
//    // FCM response
//    dd($result);
//  }

}
