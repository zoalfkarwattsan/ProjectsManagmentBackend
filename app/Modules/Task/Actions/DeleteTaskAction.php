<?php


namespace App\Modules\Task\Actions;


use App\Modules\Task\Models\Task;

class DeleteTaskAction
{
  public static function execute(Task $task)
  {
    $task->delete();
  }

}
