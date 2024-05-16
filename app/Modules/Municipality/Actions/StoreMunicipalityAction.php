<?php


namespace App\Modules\Municipality\Actions;

use App\Modules\Municipality\DTO\MunicipalityDTO;
use App\Modules\Municipality\Models\Municipality;

class StoreMunicipalityAction
{

  public static function execute(MunicipalityDTO $municipalityDTO)
  {
    $municipality = new Municipality($municipalityDTO->toArray());
    $municipality->save();
    return $municipality;
  }
}
