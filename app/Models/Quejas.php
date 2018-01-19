<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quejas extends Model
{
  public $timestamps = false;
  protected $fillable = ['fecha','cliente_id','descripcion','usuario_responsable_id','acciones','fecha_plan','evidencia','fecha_cierre','estatus_id','idcompañia','archivoqueja','uniquearchivo','archivoevidencia','uniquearchivoevidencia','proceso','producto','monto','creador_id'];

  public function cliente(){
      return $this->belongsTo(Clientes::class, 'cliente_id','id');
  }


  public function responsable(){
      return $this->belongsTo(User::class, 'usuario_responsable_id','id');
  }


  public function creador(){
      return $this->belongsTo(User::class, 'creador_id','id');
  }

  public function estatus()
  {
    return $this->belongsTo(Estatus::class,'estatus_id');
  }

}
