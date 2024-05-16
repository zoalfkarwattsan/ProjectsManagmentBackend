<?php


namespace App\Modules\Box\Actions;

use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VoteCitizenAction
{

  public static function execute(User $user)
  {
    $election = Election::where('active', 1)->first();
    if (!$election) return null;
    $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
    $box->users()->wherePivot('user_id', $user->id)->updateExistingPivot($user->id, array('voted' => 1));
    return $box;
  }
}
