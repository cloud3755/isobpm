<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sipoc extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','S','I','P','O','C','id_proceso'];
}
