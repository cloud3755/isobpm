<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedorcalifica extends Model
{
  public $timestamps = false;
  protected $fillable = ['id','idproveedor','idinsumo','pedido','tiempo','calidad','servicio','costo'];
}
