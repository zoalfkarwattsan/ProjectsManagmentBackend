<?php


namespace App\Modules\Party\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class PartyDTO extends DataTransferObject
{

  /** @var string $name */
  public $name;

  /** @var string $color */
  public $color;

  /** @var string $background_color */
  public $background_color;

  /** @var string $text_color */
  public $text_color;

  public static function fromRequest($request)
  {
    return new self(
      [
        'name' => $request['name'],
        'color' => $request['color'],
        'background_color' => $request['background_color'],
        'text_color' => $request['text_color']
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'name' => isset($request['name']) ? $request['name'] : $data->name,
        'color' => isset($request['color']) ? $request['color'] : $data->color,
        'background_color' => isset($request['background_color']) ? $request['background_color'] : $data->background_color,
        'text_color' => isset($request['text_color']) ? $request['text_color'] : $data->text_color
      ]
    );
  }
}
