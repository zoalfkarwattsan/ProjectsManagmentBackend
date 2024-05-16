<?php

namespace App\Modules\Announcement\ViewModels;

use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Announcement\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AnnouncementShowVM
{

  public static function handle($announcement)
  {
    return $announcement;
  }

  public static function toArray(Announcement $announcement)
  {
    return ['announcement' => self::handle($announcement)];
  }

  public static function toAttr(Announcement $announcement)
  {
    return self::handle($announcement);
  }
}
