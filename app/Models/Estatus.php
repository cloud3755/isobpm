<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
  public $timestamps = false;
  protected $fillable = ['nombre'];
}
