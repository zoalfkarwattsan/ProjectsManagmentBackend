<?php


namespace App\Modules\Project\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class ProjectDTO extends DataTransferObject
{

    /** @var string $name */
    public $name;

    /** @var string $description */
    public $description;

    /** @var int $user_id */
    public $user_id;

    /** @var int $project_type_id */
    public $project_type_id;

    /** @var int $status_id */
    public $status_id;

    /** @var string $start_date */
    public $start_date;

    /** @var string $due_date */
    public $due_date;

    public static function fromRequest($request)
    {
        return new self(
            [
                'name' => $request['name'],
                'description' => $request['description'],
                'user_id' => $request['user_id'] ? (int)$request['user_id'] : null,
                'project_type_id' => (int)$request['project_type_id'],
                'start_date' => $request['start_date'],
                'due_date' => $request['due_date'],
                'status_id' => 1,
            ]
        );
    }

    public static function fromRequestForUpdate($request, $data)
    {
        return new self(
            [
                'name' => isset($request['name']) ? $request['name'] : $data->name,
                'description' => isset($request['description']) ? $request['description'] : $data->description,
                'user_id' => isset($request['user_id']) ? $request['user_id'] : $data->user_id,
                'project_type_id' => isset($request['project_type_id']) ? $request['project_type_id'] : $data->project_type_id,
                'status_id' => isset($request['status_id']) ? $request['status_id'] : $data->status_id,
                'start_date' => isset($request['start_date']) ? $request['start_date'] : $data->start_date,
                'due_date' => isset($request['due_date']) ? $request['due_date'] : $data->due_date,
            ]
        );
    }
}
