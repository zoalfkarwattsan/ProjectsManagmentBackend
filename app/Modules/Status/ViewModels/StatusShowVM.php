<?php

namespace App\Modules\Status\ViewModels;

use App\Modules\Status\Models\Status;

class StatusShowVM
{

  public static function handle($status)
  {
    return $status;
  }

  public static function toArray(Status $status)
  {
    return ['TransactionStatus' => self::handle($status)];
  }

  public static function toAttr(Status $status)
  {
    return self::handle($status);
  }
}
