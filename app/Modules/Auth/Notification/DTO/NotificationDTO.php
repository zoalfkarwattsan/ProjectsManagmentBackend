<?php


namespace App\Modules\Auth\Notification\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class NotificationDTO extends DataTransferObject
{

  /** @var string $title */
  public $title;

  /** @var string $body */
  public $body;

  /** @var array $responsibles */
  public $responsibles;

  public static function fromRequest($request)
  {
    return new self(
      [
        'title' => $request['title'],
        'body' => $request['body'],
        'responsibles' => $request['responsibles'],
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'title' => isset($request['title']) ? $request['title'] : $data->title,
        'body' => isset($request['body']) ? $request['body'] : $data->body,
        'responsibles' => isset($request['responsibles']) ? $request['responsibles'] : $data->responsibles,
      ]
    );
  }
}
