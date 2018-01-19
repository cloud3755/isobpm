<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accioncorrectiva1 extends Model
{
  public $timestamps = false;
  protected $fillable = ['fechaalta','id_proceso','producti_id','documento','descipcion','responsable_id','porque1','porque2','accioncorrectiva','fechaaccion','respuestaaccion','evidencia','fechacierre','criterio','estatus_id','creador_id','indicador_id','idcompañia','uniquedocumento','uniqueevidencia','monto','area'];


  public function responsable(){
      return $this->belongsTo(User::class, 'responsable_id','id');
  }

  public function creador(){
      return $this->belongsTo(User::class, 'creador_id','id');
  }


  public function estatus()
  {
    return $this->belongsTo(Estatus::class,'estatus_id');
  }


}
