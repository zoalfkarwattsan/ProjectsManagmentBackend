<?php

namespace App\Modules\Announcement\Models;

use App\Models\Constituency;
use App\Models\Governate;
use App\Models\Province;
use App\Models\Town;
use App\Modules\Box\Models\Box;
use App\Modules\Candidate\Models\Candidate;
use App\Modules\Election\Models\Election;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'text'
  ];
}
