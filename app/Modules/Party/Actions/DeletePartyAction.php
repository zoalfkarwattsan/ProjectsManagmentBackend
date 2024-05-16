<?php


namespace App\Modules\Party\Actions;


use App\Modules\Party\Models\Party;

class DeletePartyAction
{
  public static function execute(Party $party)
  {
    $party->delete();
  }

}
