<?php

namespace App\Modules\Election\Models;

use App\Models\Constituency;
use App\Models\Governate;
use App\Models\Province;
use App\Models\Town;
use App\Modules\Box\Models\Box;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'year',
        'election_date',
        'locked',
        'active'
    ];

    public function parties()
    {
        return $this->belongsToMany(\App\Modules\Party\Models\Party::class, 'elections_vs_parties')->withPivot('order');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'elections_vs_users')->withPivot(['box_id', 'responsible_id', 'color', 'voted', 'arrived', 'outdoor']);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
