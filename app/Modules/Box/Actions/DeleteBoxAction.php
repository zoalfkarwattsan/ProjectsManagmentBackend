<?php


namespace App\Modules\Box\Actions;


use App\Modules\Box\Models\Box;

class DeleteBoxAction
{
  public static function execute(Box $box)
  {
    $box->delete();
  }

}
