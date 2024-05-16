<?php


namespace App\Modules\Candidate\Actions;

use App\Modules\Candidate\DTO\CandidateDTO;
use App\Modules\Candidate\Models\Candidate;

class UpdateCandidateAction
{
  public static function execute(Candidate $candidate, CandidateDTO $candidateDTO)
  {
    $candidate->update($candidateDTO->toArray());
    return $candidate;
  }

}
