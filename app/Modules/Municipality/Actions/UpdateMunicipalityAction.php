<?php


namespace App\Modules\Municipality\Actions;

use App\Modules\Municipality\DTO\MunicipalityDTO;
use App\Modules\Municipality\Models\Municipality;

class UpdateMunicipalityAction
{
  public static function execute(Municipality $municipality, MunicipalityDTO $municipalityDTO)
  {
    $municipality->update($municipalityDTO->toArray());
        return $municipality;
    }

}
