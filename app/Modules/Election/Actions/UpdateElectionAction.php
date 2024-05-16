<?php


namespace App\Modules\Election\Actions;

use App\Modules\Election\DTO\ElectionDTO;
use App\Modules\Election\Models\Election;

class UpdateElectionAction
{
  public static function execute(Election $election, ElectionDTO $electionDTO)
  {
    $election->update($electionDTO->toArray());
    return $election;
  }

}
