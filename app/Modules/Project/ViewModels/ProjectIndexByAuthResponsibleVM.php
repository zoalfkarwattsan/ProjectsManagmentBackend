<?php

namespace App\Modules\Project\ViewModels;

use App\Modules\Project\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectIndexByAuthResponsibleVM
{

  public static function handle()
  {
    $responsible = Auth::guard('api')->user();
    $projects = $responsible->projects;
    $arr = [];
    foreach ($projects as $user) {
      $userVM = new ProjectShowVM();
      array_push($arr, $userVM->toAttr($user));
    }
    return $arr;
  }

  public static function toArray()
  {
    return ['projects' => self::handle()];
  }
}
