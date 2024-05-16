<?php


namespace App\Modules\Candidate\Actions;


use App\Modules\Candidate\Models\Candidate;

class DeleteCandidateAction
{
  public static function execute(Candidate $candidate)
  {
    $candidate->delete();
  }

}
