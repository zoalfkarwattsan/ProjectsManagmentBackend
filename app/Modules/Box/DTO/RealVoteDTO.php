<?php


namespace App\Modules\Box\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class RealVoteDTO extends DataTransferObject
{

  /** @var int $party_id */
  public $party_id;

  /** @var int $candidate_id */
  public $candidate_id;

  /** @var int $cancelled */
  public $cancelled;

  /** @var int $white_paper */
  public $white_paper;

  public static function fromRequest($request)
  {
    return new self(
      [
        'name' => $request['name'],
        'is_closed' => (int)$request['is_closed'],
        'municipality_id' => (int)$request['municipality_id'],
        'election_id' => (int)$request['election_id'],
        'room_number' => (int)$request['room_number'],
        'sheet_id' => (int)$request['sheet_id'],
      ]
    );
  }

  public static function fromRequestForUpdate($request, $data)
  {
    return new self(
      [
        'name' => isset($request['name']) ? $request['name'] : $data->name,
        'is_closed' => isset($request['is_closed']) ? $request['is_closed'] : $data->is_closed,
        'municipality_id' => isset($request['municipality_id']) ? $request['municipality_id'] : $data->municipality_id,
        'election_id' => isset($request['election_id']) ? $request['election_id'] : $data->election_id,
        'delegate_id' => isset($request['delegate_id']) ? $request['delegate_id'] : $data->delegate_id,
        'room_number' => isset($request['room_number']) ? $request['room_number'] : $data->room_number,
        'sheet_id' => isset($request['sheet_id']) ? $request['sheet_id'] : $data->sheet_id,
      ]
    );
  }
}
