<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_indicadores_proceso extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_indicador','id_proceso'];
}
