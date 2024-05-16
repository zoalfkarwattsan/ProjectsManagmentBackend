<?php


namespace App\Modules\Election\Actions;

use App\Modules\Election\DTO\ElectionDTO;
use App\Modules\Election\Models\Election;

class StoreElectionAction
{

  public static function execute(ElectionDTO $electionDTO)
  {
    $election = new Election($electionDTO->toArray());
    $election->save();
    return $election;
  }
}
