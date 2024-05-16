<?php


namespace App\Modules\Election\Actions;


use App\Modules\Election\Models\Election;
use Illuminate\Support\Facades\DB;

class DeActivateElectionAction
{
    public static function execute(Election $election)
    {
        $election->active = 0;
        $election->update();
    }

}
