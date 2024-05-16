<?php


namespace App\Modules\Election\Actions;


use App\Modules\Election\Models\Election;
use Illuminate\Support\Facades\DB;

class ActivateElectionAction
{
  public static function execute(Election $election)
  {
    DB::table('elections')->where('id', '!=', $election->id)->update(array('active' => 0));
    $election->active = 1;
    $election->update();
  }

}
