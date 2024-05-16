<?php


namespace App\Modules\Auth\Responsible\Actions;


use App\Modules\Auth\Responsible\Models\Responsible;

class DeleteResponsibleAction
{
  public static function execute(Responsible $responsible)
  {
    $responsible->delete();
  }

}
