<?php


namespace App\Modules\Box\Actions;

use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CloseRequestBoxAction
{

  public static function execute()
  {
    $election = Election::where('active', 1)->first();
    if (!$election) return null;
    $box = $election->boxes->where('delegate_id', Auth::guard('api')->id())->first();
    $box->update(['close_request' => 1, 'is_closed' => 1]);
    return $box;
  }
}
