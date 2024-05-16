<?php

namespace App\Modules\Party\ViewModels;

use App\Modules\Party\Models\Party;

class PartyIndexVM
{

  public static function handle()
  {
    $parties = Party::all();
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
