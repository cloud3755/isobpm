<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicadores extends Model
{
  public $timestamps = false;
  protected $fillable = ['objetivo_id','nombre','descripcion','usuario_responsable_id','frecuencia_id','unidad','logica','meta','acceso','creador_id'];
}
