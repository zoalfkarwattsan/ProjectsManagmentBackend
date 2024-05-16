<?php


namespace App\Modules\Party\Actions;

use App\Modules\Party\DTO\PartyDTO;
use App\Modules\Party\Models\Party;

class StorePartyAction
{

  public static function execute(PartyDTO $partyDTO)
  {
    $party = new Party($partyDTO->toArray());
    $party->save();
    return $party;
  }
}
