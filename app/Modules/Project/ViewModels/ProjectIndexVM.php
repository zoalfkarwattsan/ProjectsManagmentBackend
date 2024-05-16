<?php

namespace App\Modules\Project\ViewModels;

use App\Modules\Project\Models\Project;

class ProjectIndexVM
{

  public static function handle()
  {
    $users = Project::all();
    $arr = [];
    foreach ($users as $user) {
      $userVM = new ProjectShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['users' => self::handle()];
  }
}
