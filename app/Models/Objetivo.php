<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    public $timestamps = false;
    protected $fillable = ['tipo_objetivo_id','nombre','descripcion','fecha','usuario_responsable_id','usuario_creador_id','id_compania'];

}
