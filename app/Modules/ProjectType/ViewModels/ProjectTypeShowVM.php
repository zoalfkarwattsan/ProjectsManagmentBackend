<?php

namespace App\Modules\ProjectType\ViewModels;

use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\ProjectType\Models\ProjectType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectTypeShowVM
{

  public static function handle($projectType)
  {

    $election = Election::where('active', 1)->first();
    if ($election) {
      $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
      $projectType->setAttribute('candidates', Candidate::where('projectType_id', $projectType->id)->where('election_id', $election->id)->get());
      $projectType->setAttribute('votes_num', count($projectType->votes->where('id', $box->id)));
      unset($projectType->votes);
    }
    return $projectType;
  }

  public static function toArray(ProjectType $projectType)
  {
    return ['projectType' => self::handle($projectType)];
  }

  public static function toAttr(ProjectType $projectType)
  {
    return self::handle($projectType);
  }
}
