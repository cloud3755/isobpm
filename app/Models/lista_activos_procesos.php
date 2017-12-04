<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_activos_procesos extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_activo','id_proceso'];
}
