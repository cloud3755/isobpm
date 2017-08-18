<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class insumos extends Model
{
  protected $fillable = ['id','Producto_o_Servicio','descripcion','tipo','idcompañia','archivo','nombreunico','size'];
}
