<?php

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempCitizen extends Model
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
        'municipality',
        'district',
        'governorate',
        'constituency',
        'election_id',
        'outdoor',
    ];
}
