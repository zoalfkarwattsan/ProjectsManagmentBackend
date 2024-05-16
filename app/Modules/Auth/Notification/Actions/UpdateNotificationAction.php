<?php


namespace App\Modules\Auth\Notification\Actions;

use App\Modules\Auth\Notification\DTO\NotificationDTO;
use App\Modules\Auth\Notification\Models\Notification;

class UpdateNotificationAction
{
  public static function execute(Notification $notification, NotificationDTO $notificationDTO)
  {
    $notification->update($notificationDTO->toArray());
    return $notification;
  }

}
