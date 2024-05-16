<?php

namespace App\Modules\Auth\RolePermission\Role\Models;

use App\Modules\Auth\Admin\Models\Admin;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Auth\RolePermission\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'guard_name'
    ];

    protected $with = [
        'admins',
        'responsibles',
        'permissions'
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function responsibles()
    {
        return $this->hasMany(Responsible::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
