<?php


namespace App\Modules\Election\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class ElectionDTO extends DataTransferObject
{

  /** @var int $fname */
  public $year;

  /** @var string $election_date */
  public $election_date;

  public static function fromRequest($request)
  {
    return new self(
      [
        'year' => (int)$request['year'],
        'election_date' => $request['election_date']
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'year' => isset($request['year']) ? $request['year'] : $data->year,
        'election_date' => isset($request['election_date']) ? $request['election_date'] : $data->election_date
      ]
    );
  }
}
