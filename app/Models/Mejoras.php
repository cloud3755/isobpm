<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mejoras extends Model
{
    public $timestamps = false;
    protected $fillable = ['tipo','proyecto','responsable_id','impacto','beneficioplan','beneficioreal','fechaactual','estatus_id','listaequipo','descripcion','creador_id'];
}
