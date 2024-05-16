<?php


namespace App\Modules\Municipality\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class MunicipalityDTO extends DataTransferObject
{

  /** @var string $name */
  public $name;

  /** @var string $color */
  public $color;

  public static function fromRequest($request)
  {
    return new self(
      [
        'name' => $request['name']
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'name' => isset($request['name']) ? $request['name'] : $data->name
      ]
    );
  }
}
