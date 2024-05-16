<?php


namespace App\Modules\Auth\Notification\Actions;

use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Notification\Models\Notification;
use App\Modules\Auth\Responsible\Models\Responsible;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StoreNotificationAction
{

    public static function execute(NotificationDTO $notificationDTO)
    {
        $notification = new Notification($notificationDTO->toArray());
        Http::withHeaders([
            'Authorization' => "key=AAAAooVI7HU:APA91bE2Pmbsu2V7TQwlw2El8knPnjaTKtBnRgvrDsinx17RkjWxKOIfDg8CzMzal4X-7oetaWJnMUtJzaMq-Ve36VJuxwiItbCbOL5L02NSCekfhKKs8WWthq9EtReEYsHzdCUZV3UU",
            "Content-Type" => "application/json"
        ])->post('https://fcm.googleapis.com/fcm/send', [
            "registration_ids" => $notificationDTO->responsibles,
            "data" => [
                "androidChannel" => "default"
            ],
            "notification" => [
                "title" => $notificationDTO->title,
                "body" => $notificationDTO->body,
            ]
        ]);
        if (isset(Auth::guard('web')->id)) {
            $notification->created_by_id = Auth::guard('web')->id;
        }
        $notification->save();
        $responsibles = Responsible::whereIn('fcm_token', $notificationDTO->responsibles)->get()->pluck('id');
        $notification->responsibles()->sync($responsibles);
        return $notification;
    }
}
