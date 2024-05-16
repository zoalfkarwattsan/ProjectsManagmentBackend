<?php


namespace App\Modules\Announcement\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class AnnouncementDTO extends DataTransferObject
{

  /** @var string $text */
  public $text;

  public static function fromRequest($request)
  {
    return new self(
      [
        'text' => $request['text']
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'text' => isset($request['text']) ? $request['text'] : $data->text
      ]
    );
  }
}
