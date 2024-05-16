<?php


namespace App\Modules\Status\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class StatusDTO extends DataTransferObject
{

  /** @var string $name */
  public $name;

  /** @var string $icon_color */
  public $icon_color;

  public static function fromRequest($request)
  {
    return new self(
      [
        'name' => $request['name'],
        'icon_color' => $request['icon_color']
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'name' => isset($request['name']) ? $request['name'] : $data->name,
        'icon_color' => isset($request['icon_color']) ? $request['icon_color'] : $data->icon_color
      ]
    );
  }
}
