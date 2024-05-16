<?php


namespace App\Modules\Candidate\Actions;

use App\Modules\Candidate\DTO\CandidateDTO;
use App\Modules\Candidate\Models\Candidate;

class StoreCandidateAction
{

  public static function execute(CandidateDTO $candidateDTO)
  {
    $candidate = new Candidate($candidateDTO->toArray());
    $candidate->save();
    return $candidate;
  }
}
