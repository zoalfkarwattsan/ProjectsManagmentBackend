<?php

namespace App\Modules\Auth\Notification\Models;

use App\Modules\Auth\Admin\Models\Admin;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Models\Project;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Notification extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'title', 'body'
  ];

  public function created_by()
  {
    return $this->belongsTo(Admin::class, 'created_by_id');
  }

  public function responsibles()
  {
    return $this->belongsToMany(Responsible::class, 'responsibles_vs_notifications', 'notification_id', 'responsible_id');
  }
}
