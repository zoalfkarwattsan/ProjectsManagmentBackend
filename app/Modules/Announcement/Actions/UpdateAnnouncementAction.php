<?php


namespace App\Modules\Announcement\Actions;

use App\Modules\Announcement\DTO\AnnouncementDTO;
use App\Modules\Announcement\Models\Announcement;

class UpdateAnnouncementAction
{
  public static function execute(Announcement $announcement, AnnouncementDTO $announcementDTO)
  {
    $announcement->update($announcementDTO->toArray());
    return $announcement;
  }

}
