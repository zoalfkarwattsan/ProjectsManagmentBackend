<?php


namespace App\Modules\Status\Actions;


use App\Modules\Status\Models\Status;

class DeleteStatusAction
{
  public static function execute(Status $status)
  {
    $status->delete();
  }

}
