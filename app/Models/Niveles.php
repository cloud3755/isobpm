<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveles extends Model
{
  public $timestamps = false;
  protected $fillable = ['nombre','valor'];
}
