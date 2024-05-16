<?php


namespace App\Modules\User\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class UserDTO extends DataTransferObject
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

    /** @var string $birth_date */
    public $birth_date;

    /** @var string $phone */
    public $phone;

    /** @var string $civil_registration */
    public $civil_registration;

    /** @var string $record_religion */
    public $record_religion;

    /** @var string $personal_religion */
    public $personal_religion;

    /** @var int $municipality_id */
    public $municipality_id;

    /** @var string $address */
    public $address;

    /** @var string $notes */
    public $notes;

    /** @var int $nationality_id */
    public $nationality_id;

    public static function fromRequest($request)
    {
        return new self(
            [
                'fname' => $request['fname'],
                'mname' => $request['mname'],
                'lname' => $request['lname'],
                'mother_name' => $request['mother_name'],
                'gender' => $request['gender'],
                'birth_date' => $request['birth_date'],
                'phone' => $request['phone'],
                'civil_registration' => $request['civil_registration'],
                'record_religion' => $request['record_religion'],
                'personal_religion' => $request['personal_religion'],
                'municipality_id' => $request['municipality_id'],
                'address' => $request['address'],
                'notes' => $request['notes'],
                'nationality_id' => $request['nationality_id'],
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
                'birth_date' => isset($request['birth_date']) ? $request['birth_date'] : $data->birth_date,
                'phone' => isset($request['phone']) ? $request['phone'] : $data->phone,
                'civil_registration' => isset($request['civil_registration']) ? $request['civil_registration'] : $data->civil_registration,
                'record_religion' => isset($request['record_religion']) ? $request['record_religion'] : $data->record_religion,
                'personal_religion' => isset($request['personal_religion']) ? $request['personal_religion'] : $data->personal_religion,
                'municipality_id' => isset($request['municipality_id']) ? $request['municipality_id'] : $data->municipality_id,
                'address' => isset($request['address']) ? $request['address'] : $data->address,
                'notes' => isset($request['notes']) ? $request['notes'] : $data->notes,
                'nationality_id' => isset($request['nationality_id']) ? $request['nationality_id'] : $data->nationality_id,
            ]
        );
    }
}
