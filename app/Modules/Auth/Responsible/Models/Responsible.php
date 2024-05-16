<?php

namespace App\Modules\Auth\Responsible\Models;

use App\Modules\Auth\Admin\Models\Admin;
use App\Modules\Auth\Notification\Models\Notification;
use App\Modules\Project\Models\Project;
use App\Modules\Task\Models\Task;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Models\Role;

class Responsible extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fname', 'mname', 'lname', 'email', 'responsible_type_id', 'phone', 'password', 'fcm_token', 'created_by', 'address', 'phone', 'image', 'last_sync_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
    ];

    protected $with = [
        'responsible_types'
    ];

//  protected $with = ['projects'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_vs_responsibles')->withPivot(['created_at']);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'responsible_id');
    }

    public function responsible_types()
    {
        return $this->belongsToMany(ResponsibleType::class, 'responsibles_vs_responsible_types');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function created_by()
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsToMany(Admin::class, 'updated_by_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'responsibles_vs_notifications', 'responsible_id', 'notification_id');
    }
}
