<?php


namespace App\Modules\User\Actions;


use App\Modules\Election\Models\Election;
use App\Modules\User\Models\TempCitizen;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;

class ImmigrantTempUserAction
{
    public static function execute(User $user, Election $election)
    {
        DB::table('elections_vs_users')->where('user_id', $user->id)->where('election_id', $election->id)->update(['responsible_id' => null, 'outdoor' => 1]);
        $user->update();
    }

}
