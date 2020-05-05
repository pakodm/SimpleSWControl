<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $fillable = [
        'descripcion',
        'razon_social',
        'rfc',
        'calle',
        'num_extrior',
        'num_interior',
        'colonia',
        'ciudad',
        'estado',
        'cp',
        'correo_electronico'
    ];
}
