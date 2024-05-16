<?php

namespace App\Modules\User\Models;

use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use App\Modules\Party\Models\Party;
use App\Modules\Project\Models\Project;
use App\Modules\Stock\Transaction\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
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
        'gender',
        'birth_date',
        'phone',
        'civil_registration',
        'record_religion',
        'personal_religion',
        'created_by_id',
        'responsible_id',
        'municipality_id',
        'district',
        'governorate',
        'constituency',
        'notes',
        'address',
        'outdoor',
        'nationality_id'
    ];

    protected $with = [
        'municipality',
        'nationality'
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class, 'elections_vs_users')->withPivot(['box_id', 'responsible_id', 'color', 'voted', 'arrived', 'outdoor']);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'destination');
    }
}
