<?php

namespace App\Modules\Party\ViewModels;

use App\Modules\Election\Models\Election;
use App\Modules\Party\Models\Party;
use Carbon\Carbon;

class PartyIndexByActiveElectionVM
{

  public static function handle()
  {
    $election = Election::where('active', 1)->first();
    if (!$election) return null;
    $parties = $election->parties;
    $arr = [];
    foreach ($parties as $party) {
      $partyVM = new PartyShowVM();
      array_push($arr, $partyVM->toAttr($party));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['parties' => self::handle()];
  }
}
