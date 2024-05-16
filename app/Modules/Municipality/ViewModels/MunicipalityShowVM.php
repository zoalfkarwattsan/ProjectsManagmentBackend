<?php

namespace App\Modules\Municipality\ViewModels;

use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Municipality\Models\Municipality;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MunicipalityShowVM
{

  public static function handle($municipality)
  {

    $election = Election::where('active', 1)->first();
    if ($election) {
      $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
      $municipality->setAttribute('candidates', Candidate::where('municipality_id', $municipality->id)->where('election_id', $election->id)->get());
      $municipality->setAttribute('votes_num', count($municipality->votes->where('id', $box->id)));
      unset($municipality->votes);
    }
    return $municipality;
  }

  public static function toArray(Municipality $municipality)
  {
    return ['municipality' => self::handle($municipality)];
  }

  public static function toAttr(Municipality $municipality)
  {
    return self::handle($municipality);
  }
}
