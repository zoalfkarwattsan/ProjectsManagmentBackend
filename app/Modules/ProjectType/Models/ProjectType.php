<?php

namespace App\Modules\ProjectType\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
  use HasFactory;

  protected $fillable = [
    'name'
  ];
}
