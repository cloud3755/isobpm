<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mejoraetapas extends Model
{
    public $timestamps = false;
    protected $fillable =['id_mejoras','etapa','descripcion','archivo','fecha','uniquearchivo'];
}
