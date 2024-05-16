<?php

namespace App\Modules\Candidate\Models;

use App\Modules\Box\Models\Box;
use App\Modules\Municipality\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'mother_name',
        'birth_date',
        'gender',
        'personal_religion',
        'civil_registration',
        'record_religion',
        'party_id',
        'municipality_id',
        'election_id',
        'image'
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class, 'boxes_vs_candidates')->withPivot(['votes_num']);
    }
}
