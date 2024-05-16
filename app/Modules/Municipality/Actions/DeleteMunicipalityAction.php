<?php


namespace App\Modules\Municipality\Actions;


use App\Modules\Municipality\Models\Municipality;

class DeleteMunicipalityAction
{
  public static function execute(Municipality $municipality)
  {
    $municipality->delete();
  }

}
