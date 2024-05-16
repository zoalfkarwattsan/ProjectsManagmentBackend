<?php


namespace App\Modules\Project\Actions;


use App\Modules\Project\Models\Project;

class DeleteProjectAction
{
  public static function execute(Project $project)
  {
    $project->delete();
  }

}
