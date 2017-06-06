<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
  public $timestamps = false;
  protected $fillable = ['indicador_id','periodo','valor','mes','numero'];
}
