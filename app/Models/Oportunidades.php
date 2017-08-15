<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oportunidades extends Model
{
  public $timestamps = false;
  protected $fillable = ['procesos_id','actividad','oportunidad_id','modo_falla','descripcion_modo_falla','esfuerzo', 'impacto','oportunidad_potencial','controles' ,'esfuerzo2','impacto2','oportunidad_real','idcompañia','id_area'];
}
