<?php

namespace App\Modules\Announcement\ViewModels;

use App\Modules\Announcement\Models\Announcement;

class AnnouncementIndexVM
{

  public static function handle()
  {
    $announcements = Announcement::all();
    $arr = [];
    foreach ($announcements as $announcement) {
      $announcementVM = new AnnouncementShowVM();
      array_push($arr, $announcementVM->toAttr($announcement));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['announcements' => self::handle()];
  }
}
