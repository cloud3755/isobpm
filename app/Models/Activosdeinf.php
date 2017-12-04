<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activosdeinf extends Model
{
    protected $fillable = ['nombre','descripcion','responsable','id_creador','id_compania'];
}
