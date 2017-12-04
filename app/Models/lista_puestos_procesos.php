<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class lista_puestos_procesos extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_puesto','id_proceso'];
}
