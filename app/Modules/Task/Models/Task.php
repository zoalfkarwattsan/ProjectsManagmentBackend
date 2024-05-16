<?php

namespace App\Modules\Task\Models;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Project\Models\Project;
use App\Modules\Status\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status_id', 'project_id', 'responsible_id', 'due_date', 'started_date', 'completed_date', 'failed_reason'];

    protected $with = ['status', 'responsible'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Responsible::class);
    }
}
