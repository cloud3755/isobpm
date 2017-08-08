<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','id_compania','proveedor','email','telefono','activo','direccion','observaciones'];

}
