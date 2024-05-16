<?php

namespace App\Modules\Box\Models;

use App\Models\Constituency;
use App\Models\Governate;
use App\Models\Province;
use App\Models\Town;
use App\Modules\Auth\Responsible\Models\Responsible;
use App\Modules\Election\Models\Election;
use App\Modules\Election\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elector extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'civil_registration_from',
    'civil_registration_to',
    'religion',
    'gender',
    'box_id'
  ];

  public function box()
  {
    return $this->belongsTo(Box::class);
  }
}
