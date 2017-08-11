<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archivosproveedores extends Model
{
    //
    protected $fillable = ['id','nombre','archivo','nombreunico','size','id_proveedor', 'id_user','id_compania'];

}
