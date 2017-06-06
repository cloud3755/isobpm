<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quejas extends Model
{
  public $timestamps = false;
  protected $fillable = ['fecha','cliente_id','descripcion','usuario_responsable_id','acciones','fecha_plan','evidencia','fecha_cierre','estatus_id','idcompañia','archivoqueja','uniquearchivo','archivoevidencia','uniquearchivoevidencia','proceso','producto','monto'];
}
