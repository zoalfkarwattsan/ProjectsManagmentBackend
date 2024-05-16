<?php

namespace App\Modules\Party\Models;

use App\Modules\Box\Models\Box;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'color',
        'background_color',
        'text_color'
    ];

    protected $with = [
        'candidates'
    ];

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'boxes_vs_parties')->withPivot(['votes_num']);
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class, 'elections_vs_parties')->withPivot(['votes_num']);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
