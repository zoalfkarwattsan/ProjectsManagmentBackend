<?php


namespace App\Modules\Box\Actions;

use App\Modules\Box\DTO\BoxDTO;
use App\Modules\Box\Models\Box;
use App\Modules\Election\Models\Election;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArrivedCitizenAction
{

    public static function execute(User $user)
    {
        $election = Election::where('active', 1)->first();
        if (!$election) return null;
        $election->users()->wherePivot('user_id', $user->id)->updateExistingPivot($user->id, array('arrived' => 1));
        return $election;
    }
}
