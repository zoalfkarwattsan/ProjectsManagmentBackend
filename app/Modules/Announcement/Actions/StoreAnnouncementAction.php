<?php


namespace App\Modules\Announcement\Actions;

use App\Modules\Announcement\DTO\AnnouncementDTO;
use App\Modules\Announcement\Models\Announcement;

class StoreAnnouncementAction
{

  public static function execute(AnnouncementDTO $announcementDTO)
  {
    $announcement = new Announcement($announcementDTO->toArray());
    $announcement->save();
    return $announcement;
  }
}
