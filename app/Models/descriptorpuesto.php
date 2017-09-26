<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class descriptorpuesto extends Model
{
    //
    protected $fillable = ['id','id_puesto','id_empresa','id_area','personalacargo','reportaa','montovalores','mision','funciones','responsabilidades','autoridades','capacitacion','herramientas','softwareactivos'];

}
