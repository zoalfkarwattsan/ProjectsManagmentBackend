<?php


namespace App\Modules\Auth\Responsible\Actions;

use App\Modules\Auth\Responsible\Models\Responsible;
use Illuminate\Support\Facades\DB;

class DeactivateTeamMemberAction
{
    public static function execute(Responsible $responsible)
    {
        $responsible->active = 0;
        $responsible->update();
    }

}
