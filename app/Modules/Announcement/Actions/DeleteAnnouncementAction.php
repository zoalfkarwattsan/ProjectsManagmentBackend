<?php


namespace App\Modules\Announcement\Actions;


use App\Modules\Announcement\Models\Announcement;

class DeleteAnnouncementAction
{
  public static function execute(Announcement $announcement)
  {
    $announcement->delete();
  }

}
