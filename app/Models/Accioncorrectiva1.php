<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accioncorrectiva1 extends Model
{
  public $timestamps = false;
  protected $fillable = ['fechaalta','id_proceso','producti_id','documento','descipcion','responsable_id','porque1','porque2','accioncorrectiva','fechaaccion','respuestaaccion','evidencia','fechacierre','criterio','estatus_id','creador_id','indicador_id','idcompañia','uniquedocumento','uniqueevidencia','monto','area'];
}
