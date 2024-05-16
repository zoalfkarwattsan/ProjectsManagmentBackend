<?php


namespace App\Modules\Party\Actions;

use App\Modules\Party\DTO\PartyDTO;
use App\Modules\Party\Models\Party;

class UpdatePartyAction
{
  public static function execute(Party $party, PartyDTO $partyDTO)
  {
    $party->update($partyDTO->toArray());
    return $party;
  }

}
