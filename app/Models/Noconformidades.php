<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noconformidades extends Model
{
  public $timestamps = false;
  protected $fillable = ['fecha','proceso_id','producto_id','documento','evidenciapertura','apertura_unic','descripcion','usuario_responsable_id','acciones','fecha_plan','evidencia','evidencia_unic','fecha_cierre','estatus_id','monto','idcompañia','id_area'];

  public function responsable()
  {
    return $this->belongsTo(User::class, 'usuario_responsable_id','id');
  }


}
