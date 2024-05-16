<?php


namespace App\Modules\ProjectVsResponsible\DTO;


use Spatie\DataTransferObject\DataTransferObject;

class ProjectVsResponsibleDTO extends DataTransferObject
{
  /** @var int $responsible_id */
  public $responsible_id;

  public static function fromRequest(
    $responsible_id
  )
  {
    return new self([
      'responsible_id' => (int)$responsible_id
    ]);
  }
}
