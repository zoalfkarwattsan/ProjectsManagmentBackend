<?php

namespace App\Modules\Candidate\ViewModels;

use App\Modules\Candidate\Models\Candidate;

class CandidateIndexVM
{

  public static function handle()
  {
    $candidates = Candidate::all();
    $arr = [];
    foreach ($candidates as $candidate) {
      $candidateVM = new CandidateShowVM();
      array_push($arr, $candidateVM->toAttr($candidate));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['candidates' => self::handle()];
  }
}
