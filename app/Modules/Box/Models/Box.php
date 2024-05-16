<?php

namespace App\Modules\Box\Models;

use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use App\Modules\Party\Models\Party;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'election_id',
        'municipality_id',
        'delegate_id',
        'is_closed',
        'close_request',
        'name',
        "room_number",
        "sheet_id",
        'last_sync_at'
    ];

    protected $with = [
        'municipality',
        'electors',
        'delegate'
    ];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function delegate()
    {
        return $this->belongsTo(Responsible::class, 'delegate_id');
    }

    public function electors()
    {
        return $this->hasMany(Elector::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'elections_vs_users')->withPivot(['voted', 'color', 'responsible_id']);
    }

    public function parties()
    {
        return $this->belongsToMany(Party::class, 'boxes_vs_parties')->withPivot(['votes_num']);
    }

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'boxes_vs_candidates')->withPivot(['votes_num']);
    }
}
