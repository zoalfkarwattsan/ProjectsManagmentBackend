<?php


namespace App\Modules\Auth\Notification\Actions;


use App\Modules\Auth\Notification\Models\Notification;

class DeleteNotificationAction
{
  public static function execute(Notification $notification)
  {
    $notification->delete();
  }

}
