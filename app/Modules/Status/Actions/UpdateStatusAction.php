<?php


namespace App\Modules\Status\Actions;

use App\Modules\Status\DTO\StatusDTO;
use App\Modules\Status\Models\Status;

class UpdateStatusAction
{
  public static function execute(Status $status, StatusDTO $statusDTO)
  {
    $status->update($statusDTO->toArray());
    return $status;
  }

}
