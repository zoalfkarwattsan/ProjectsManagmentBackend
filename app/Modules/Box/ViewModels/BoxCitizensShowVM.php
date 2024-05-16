<?php

namespace App\Modules\Box\ViewModels;

use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BoxCitizensShowVM
{
  public static function handle()
  {
    $election = Election::where('active', 1)->first();
    if (!$election) return null;
    $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
    if (!$box) return null;
    $box->setAttribute('electors', $box->electors);
    $tempBox = $box;
    $voted_num = count($tempBox->users->where('voted', 1));
    $unvoted_num = count($tempBox->users->where('voted', 0));
    $box->setAttribute('voted_citizens_num', $voted_num);
    $box->setAttribute('unvoted_citizens_num', $unvoted_num);
    return $box;
  }

  public static function toArray()
  {
    return ['box' => self::handle()];
  }

  public static function toAttr()
  {
    return self::handle();
  }
}
