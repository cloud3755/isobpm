<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
  protected $fillable = ['id_plan','razonSocial','domicilio','correo','telefono','rubro','uso','codigo','fecha','status_id','cuota_usada','img','id_creador'];
}
