<?php


namespace App\Modules\User\Actions;


use App\Modules\User\Models\TempCitizen;
use App\Modules\User\Models\User;

class DeleteTempUserAction
{
  public static function execute(TempCitizen $user)
  {
    $user->delete();
  }

}
