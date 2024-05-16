<?php

namespace App\Modules\Election\Models;

use App\Models\Constituency;
use App\Models\Governate;
use App\Models\Province;
use App\Models\Town;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
  ];
}
