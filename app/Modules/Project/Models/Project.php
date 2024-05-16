<?php

namespace App\Modules\Project\Models;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\ProjectType\Models\ProjectType;
use App\Modules\Status\Models\Status;
use App\Modules\Task\Models\Task;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name', 'description', 'user_id', 'project_type_id', 'status_id', 'created_by', 'updated_by', 'due_date', 'start_date'
  ];

  protected $with = ['status', 'project_type', 'tasks', 'tasksForAuthUser', 'responsibles', 'user'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function status()
  {
    return $this->belongsTo(Status::class);
  }

  public function project_type()
  {
    return $this->belongsTo(ProjectType::class);
  }

  public function tasks()
  {
    return $this->hasMany(Task::class);
  }

  public function tasksForAuthUser()
  {
    if (Auth::guard('api')->user()) {
      return $this->hasMany(Task::class)->where('responsible_id', '=', Auth::guard('api')->user()->id);
    } else {
      return $this->belongsTo(ProjectType::class);
    }
  }

  public function responsibles()
  {
    return $this->belongsToMany(Responsible::class, 'projects_vs_responsibles');
  }
}
