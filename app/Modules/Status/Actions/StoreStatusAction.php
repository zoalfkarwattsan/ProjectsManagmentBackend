<?php


namespace App\Modules\Status\Actions;

use App\Modules\Status\DTO\StatusDTO;
use App\Modules\Status\Models\Status;

class StoreStatusAction
{

  public static function execute(StatusDTO $statusDTO)
  {
    $status = new Status($statusDTO->toArray());
    $status->save();
    return $status;
  }
}
