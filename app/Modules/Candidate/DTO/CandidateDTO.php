<?php


namespace App\Modules\Candidate\DTO;

use App\Helpers\Files;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class CandidateDTO extends DataTransferObject
{

    /** @var string $fname */
    public $fname;

    /** @var string $mname */
    public $mname;

    /** @var string $lname */
    public $lname;

    /** @var string $mother_name */
    public $mother_name;

    /** @var string $gender */
    public $gender;

    /** @var int $party_id */
    public $party_id;

    /** @var int $election_id */
    public $election_id;

    public $image;

    public static function fromRequest($request)
    {
        return new self(
            [
                'fname' => $request['fname'],
                'mname' => $request['mname'],
                'lname' => $request['lname'],
                'mother_name' => $request['mother_name'],
                'gender' => $request['gender'],
                'party_id' => $request['party_id'],
                'election_id' => $request['election_id'],
                'image' => $request['image'] ?? 'storage/avatar.png',
            ]
        );
    }

    public static function fromRequestForUpdate($request, $data)
    {
        return new self(
            [
                'fname' => isset($request['fname']) ? $request['fname'] : $data->fname,
                'mname' => isset($request['mname']) ? $request['mname'] : $data->mname,
                'lname' => isset($request['lname']) ? $request['lname'] : $data->lname,
                'mother_name' => isset($request['mother_name']) ? $request['mother_name'] : $data->mother_name,
                'gender' => isset($request['gender']) ? $request['gender'] : $data->gender,
                'party_id' => isset($request['party_id']) ? $request['party_id'] : $data->party_id,
                'election_id' => isset($request['election_id']) ? $request['election_id'] : $data->election_id,
                'image' => isset($request['image']) ? $request['image'] : 'storage/avatar.png',
            ]
        );
    }
}
