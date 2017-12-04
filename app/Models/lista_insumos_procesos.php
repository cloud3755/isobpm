<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lista_insumos_procesos extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_insumo','id_proceso'];
}
