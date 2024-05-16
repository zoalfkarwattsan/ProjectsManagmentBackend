<?php


namespace App\Modules\Task\DTO;

use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;


class TaskDTO extends DataTransferObject
{

    /** @var string $description */
    public $description;

    /** @var string $name */
    public $name;

    /** @var string $status_id */
    public $status_id;

    /** @var int $project_id */
    public $project_id;

    /** @var int $responsible_id */
    public $responsible_id;

    /** @var string $due_date */
    public $due_date;

    /** @var string $started_date */
    public $started_date;

    /** @var string $completed_date */
    public $completed_date;

    /** @var string $failed_reason */
    public $failed_reason;

    public static function fromRequest($request)
    {
        return new self(
            [
                'name' => $request['name'],
                'description' => $request['description'],
                'status_id' => 1,
                'project_id' => $request['project_id'],
                'responsible_id' => $request['responsible_id'],
                'due_date' => $request['due_date'] ?? $request['started_date'],
                'started_date' => $request['started_date'],
                'completed_date' => $request['completed_date'],
                'failed_reason' => $request['failed_reason'],
            ]
        );
    }

    public static function fromRequestForUpdate($request, $data)
    {
        return new self(
            [
                'name' => isset($request['name']) ? $request['name'] : $data->name,
                'description' => isset($request['description']) ? $request['description'] : $data->description,
                'status_id' => isset($request['status_id']) ? $request['status_id'] : $data->status_id,
                'project_id' => isset($request['project_id']) ? $request['project_id'] : $data->project_id,
                'responsible_id' => isset($request['responsible_id']) ? $request['responsible_id'] : $data->responsible_id,
                'due_date' => isset($request['due_date']) ? $request['due_date'] : $data->due_date,
                'started_date' => isset($request['started_date']) ? $request['started_date'] : $data->started_date,
                'completed_date' => isset($request['completed_date']) ? $request['completed_date'] : $data->completed_date,
                'failed_reason' => isset($request['failed_reason']) ? $request['failed_reason'] : $data->failed_reason,
            ]
        );
    }
}
