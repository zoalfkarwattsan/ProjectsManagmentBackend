<?php


namespace App\Modules\Election\Actions;


use App\Modules\Election\Models\Election;

class DeleteElectionAction
{
  public static function execute(Election $election)
  {
    $election->delete();
  }

}
