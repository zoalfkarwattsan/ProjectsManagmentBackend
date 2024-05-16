<?php

namespace App\Modules\Candidate\ViewModels;

use App\Modules\Candidate\Models\Candidate;

class CandidateShowVM
{

  public static function handle($candidate)
  {
    return $candidate;
  }

  public static function toArray(Candidate $candidate)
  {
    return ['candidate' => self::handle($candidate)];
  }

  public static function toAttr(Candidate $candidate)
  {
    return self::handle($candidate);
  }
}
