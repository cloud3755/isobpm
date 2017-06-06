<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analisisriesgos extends Model
{
  public $timestamps = false;
  protected $fillable = ['procesos_id','actividad','riesgo_id','modo_falla','descripcion_modo_falla','Severidad', 'probabilidad','riesgo_inherente','controles' ,'Severidad2','probabilidad2','riesgo_residual','idcompañia','id_area'];
}
